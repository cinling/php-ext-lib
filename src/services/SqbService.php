<?php


namespace cin\extLib\services;


use cin\extLib\consts\FileCacheKey;
use cin\extLib\consts\Sqb;
use cin\extLib\exceptions\ApiException;
use cin\extLib\traits\ApiTractLogTrait;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\HttpUtil;
use cin\extLib\utils\JsonUtil;
use cin\extLib\utils\TimeUtil;
use cin\extLib\vos\api\sqb\SqbActivateRequest;
use cin\extLib\vos\api\sqb\SqbActivateResponse;
use cin\extLib\vos\api\sqb\SqbCheckinRequest;
use cin\extLib\vos\api\sqb\SqbCheckinResponse;
use cin\extLib\vos\api\sqb\SqbPayGoodsDetailVo;
use cin\extLib\vos\api\sqb\SqbPayRequest;
use cin\extLib\vos\api\sqb\SqbPayResponse;
use cin\extLib\vos\config\SqbConfVo;

/**
 * Class SqbService 收钱吧接口服务
 * @package cin\extLib\services
 */
class SqbService {
    use SingleTrait;
    use ApiTractLogTrait;


    /**
     * @var SqbConfVo
     */
    protected $conf;

    /**
     * SqbService constructor.
     */
    protected function __construct() {
        $this->conf = new SqbConfVo();
        $this->setBaseApiConfVo($this->conf);
    }

    /**
     * 生成签名 Header 内容
     * @param array $params 请求参数
     * @param string $sn 服务商序号 或 终端序号
     * @param string $key 服务商密钥 或 终端key
     * @return string
     */
    protected function genAuthorizationHeaderItem(array $params, $sn, $key) {
        return "Authorization:" . $sn . " " . md5( json_encode($params) . $key);
    }

    /**
     * 请求激活接口
     * @param array $extParams 额外的请求参数
     * @return SqbActivateResponse
     */
    protected function requestTerminal_activate($extParams = []) {
        $url = $this->conf->apiDomain . Sqb::UrlActivate;
        $request = new SqbActivateRequest();
        $request->app_id = $this->conf->appId;
        $request->code = $this->conf->code;
        $request->device_id = $this->conf->deviceId;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $authorization = $this->genAuthorizationHeaderItem($params, $this->conf->vendorSn, $this->conf->vendorKey);
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->apiTractLog("收钱吧-激活", $url, $params, $json);
        return SqbActivateResponse::initByJson($json);
    }

    /**
     * 请求签到接口
     * @param array $extParams 额外的请求参数
     * @return SqbCheckinResponse
     * @throws ApiException
     */
    protected function requestTerminal_checkin($extParams = []) {
        $terminalSn = $this->getTerminalSn();

        $url = $this->conf->apiDomain . Sqb::UrlCheckin;
        $request = new SqbCheckinRequest();
        $request->terminal_sn = $terminalSn;
        $request->device_id = $this->conf->deviceId;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $authorization = $this->genAuthorizationHeaderItem($params, $terminalSn, $this->getTerminalKey());
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->apiTractLog("收钱吧-签到", $url, $params, $json);
        return SqbCheckinResponse::initByJson($json);
    }

    /**
     * 请求支付接口
     * @param $sn
     * @param $totalAmount
     * @param $subject
     * @param $dynamicId
     * @param null $payway
     * @param array $goodsDetails
     * @param string $operator
     * @param array $extParams 额外的请求参数
     * @return SqbPayResponse
     * @throws ApiException
     */
    protected function requestUpay_v2_pay($sn, $totalAmount, $subject, $dynamicId, $payway = null, array $goodsDetails = [], $operator = "", $extParams = []) {
        if (empty($operator)) {
            $operator = $this->conf->defaultOperator;
        }

        $request = new SqbPayREquest();
        $request->terminal_sn = $this->getTerminalSn();
        $request->client_sn = $sn;
        $request->total_amount = $totalAmount;
        $request->subject = $subject;
        $request->dynamic_id = $dynamicId;
        $request->payway = $payway;
        $request->goods_details = $goodsDetails;
        $request->operator = $operator;
        $request->notify_url = $this->conf->notifyUrl;
        $request->setExtParams($extParams);

        $url = $this->conf->apiDomain . Sqb::UrlPay;
        $params = $request->toArray();
        $authorization = $this->genAuthorizationHeaderItem($params, $this->getTerminalSn(), $this->getTerminalKey());
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->apiTractLog("收钱吧-支付", $url, $params, $json);
        return SqbPayResponse::initByJson($json);
    }

    /**
     * 获取终端编号
     * @return string
     * @throws ApiException
     */
    protected function getTerminalSn() {
        $fileCacheSrv = FileCacheService::getIns();

        $terminalSn = $fileCacheSrv->get(FileCacheKey::SqbTerminalSn);
        if (empty($terminalSn)) {
            $response = $this->requestTerminal_activate();
            if ($response->hasError()) {
                throw new ApiException($response->error_code);
            }
            $terminalSn = $response->biz_response->terminal_sn;
            $terminalKey = $response->biz_response->terminal_key;
            // 缓存信息
            $fileCacheSrv->set(FileCacheKey::SqbTerminalSn, $terminalSn);
            $duration = TimeUtil::getDateEnd() - time(); // 有效时间是今天的 23:59:59
            $fileCacheSrv->set(FileCacheKey::SqbTerminalKey, $terminalKey, $duration);
        }
        return $terminalSn;
    }

    /**
     * 获取终端密钥
     * @return string
     * @throws ApiException
     */
    protected function getTerminalKey() {
        $fileCacheSrv = FileCacheService::getIns();

        $terminalKey = $fileCacheSrv->get(FileCacheKey::SqbTerminalKey);
        if (empty($terminalKey)) {
            $response = $this->requestTerminal_checkin($this->getTerminalSn());
            if ($response->hasError()) {
                throw new ApiException($response->result_code);
            }
            $duration = TimeUtil::getDateEnd() - time(); // 有效时间是今天的 23:59:59
            $terminalKey = $response->biz_response->terminal_key;
            $fileCacheSrv->set(FileCacheKey::SqbTerminalKey, $terminalKey, $duration);
        }
        return $terminalKey;
    }
}