<?php


namespace cin\extLib\services;


use cin\extLib\consts\FileCacheKey;
use cin\extLib\consts\Sqb;
use cin\extLib\exceptions\ApiException;
use cin\extLib\traits\ApiTractLogTrait;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\HttpUtil;
use cin\extLib\vos\api\sqb\SqbActivateRequest;
use cin\extLib\vos\api\sqb\SqbActivateResponse;
use cin\extLib\vos\api\sqb\SqbCheckinRequest;
use cin\extLib\vos\api\sqb\SqbCheckinResponse;
use cin\extLib\vos\api\sqb\SqbPayRequest;
use cin\extLib\vos\api\sqb\SqbPayResponse;
use cin\extLib\vos\api\sqb\SqbPreCreateRequest;
use cin\extLib\vos\api\sqb\SqbPreCreateResponse;
use cin\extLib\vos\config\SqbConfVo;

/**
 * Class SqbService 收钱吧接口服务
 * @package cin\extLib\services
 * @see https://doc.shouqianba.com/zh-cn/api/apiflow.html 文檔地址
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
     * 重置终端（清理所有缓存数据，重新进行激活）
     */
    public function restore() {
        $fileCacheSrv = FileCacheService::getIns();
        $fileCacheSrv->del(FileCacheKey::SqbTerminalSn);
        $fileCacheSrv->del(FileCacheKey::SqbTerminalKey);
        $fileCacheSrv->del(FileCacheKey::SqbCheckinFlag);
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
     * 处理重新签到
     * @param $terminalSn
     * @throws ApiException
     */
    protected function autoReCheckin($terminalSn) {
        $fileCacheSrv = FileCacheService::getIns();

        // 判断是否需要重签
        $flag = $fileCacheSrv->get(FileCacheKey::SqbCheckinFlag);
        if (empty($flag)) {
            $response = $this->requestTerminal_checkin($terminalSn);
            if ($response->hasError()) {
                throw new ApiException($response->result_code);
            }

            $terminalSn = $response->biz_response->terminal_sn;
            $terminalKey = $response->biz_response->terminal_key;
            // 更新缓存信息
            $fileCacheSrv->set(FileCacheKey::SqbTerminalSn, $terminalSn);
            $fileCacheSrv->set(FileCacheKey::SqbTerminalKey, $terminalKey);
            $fileCacheSrv->set(FileCacheKey::SqbCheckinFlag, time(), $this->conf->checkinDuration);
        }
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
            $fileCacheSrv->set(FileCacheKey::SqbTerminalKey, $terminalKey);
            $fileCacheSrv->set(FileCacheKey::SqbCheckinFlag, time(), $this->conf->checkinDuration);
        }
        $this->autoReCheckin($terminalSn);
        return $terminalSn;
    }

    /**
     * 获取终端密钥
     * @return string
     */
    protected function getTerminalKey() {
        $fileCacheSrv = FileCacheService::getIns();
        return $fileCacheSrv->get(FileCacheKey::SqbTerminalKey);
    }

    /**
     * 请求激活接口
     * @param array $extParams 额外的请求参数
     * @return SqbActivateResponse
     */
    protected function requestTerminal_activate($extParams = []) {
        $request = new SqbActivateRequest();
        $request->app_id = $this->conf->appId;
        $request->code = $this->conf->code;
        $request->device_id = $this->conf->deviceId;
        $request->setExtParams($extParams);

        $url = $this->conf->apiDomain . Sqb::UrlActivate;
        $params = $request->toArray();
        $authorization = $this->genAuthorizationHeaderItem($params, $this->conf->vendorSn, $this->conf->vendorKey);
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->apiTractLog("收钱吧-激活", $url, $params, $json);
        return SqbActivateResponse::initByJson($json);
    }

    /**
     * 请求签到接口
     * @param $terminalSn
     * @param array $extParams 额外的请求参数
     * @return SqbCheckinResponse
     */
    protected function requestTerminal_checkin($terminalSn, $extParams = []) {
        $request = new SqbCheckinRequest();
        $request->terminal_sn = $terminalSn;
        $request->device_id = $this->conf->deviceId;
        $request->setExtParams($extParams);

        $url = $this->conf->apiDomain . Sqb::UrlCheckin;
        $params = $request->toArray();
        $authorization = $this->genAuthorizationHeaderItem($params, $terminalSn, $this->getTerminalKey());
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->apiTractLog("收钱吧-签到", $url, $params, $json);
        return SqbCheckinResponse::initByJson($json);
    }

    /**
     * 支付接口。需要客户提供付款二维码（条形码）
     * @param $clientSn
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
    protected function requestUpay_v2_pay($clientSn, $totalAmount, $subject, $dynamicId, $payway = null, array $goodsDetails = [], $operator = "", $extParams = []) {
        if (empty($operator)) {
            $operator = $this->conf->defaultOperator;
        }

        $request = new SqbPayREquest();
        $request->terminal_sn = $this->getTerminalSn();
        $request->client_sn = $clientSn;
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
     * 预付款
     * @param string $clientSn 订单编号
     * @param string|int $totalAmount 总价。单位：分
     * @param string $notifyUrl 支付成功后的回調地址
     * @param string $subject
     * @param $payway
     * @param string $subPayway
     * @param array $goodsDetail
     * @param string $operator
     * @param array $extParams
     * @return SqbPreCreateResponse
     * @throws ApiException
     * @see https://doc.shouqianba.com/zh-cn/api/interface/precreate.html 文档地址
     */
    protected function requestUpay_v2_precreate($clientSn, $totalAmount, $notifyUrl, $subject, $payway, $subPayway = Sqb::PreCreateSubPayWayWap, array $goodsDetail = [], $operator = "", $extParams = []) {
        if (empty($operator)) {
            $operator = $this->conf->defaultOperator;
        }
        $terminalSn = $this->getTerminalSn();

        $request = new SqbPreCreateRequest();
        $request->terminal_sn = $terminalSn;
        $request->client_sn = $clientSn;
        $request->total_amount = $totalAmount;
        $request->notify_url = $notifyUrl;
        $request->subject = $subject;
        $request->payway = $payway;
        $request->sub_payway = $subPayway;
        $request->goods_details = $goodsDetail;
        $request->operator = $operator;
        $request->setExtParams($extParams);

        $url = $this->conf->apiDomain . Sqb::UrlPreCreate;
        $params = $request->toArray();
        $authorization = $this->genAuthorizationHeaderItem($params, $terminalSn, $this->getTerminalKey());
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->apiTractLog("收钱吧-预付款", $url, $params, $json);
        return SqbPreCreateResponse::initByJson($json);
    }
}