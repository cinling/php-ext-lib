<?php


namespace cin\extLib\services;


use cin\extLib\consts\FileCacheKey;
use cin\extLib\consts\Sqb;
use cin\extLib\exceptions\ApiException;
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
 *
 * @deprecated 暂未测试
 */
class SqbService {
    use SingleTrait;


    /**
     * @var SqbConfVo
     */
    protected $confVo;

    /**
     * SqbService constructor.
     */
    protected function __construct() {
        $this->confVo = new SqbConfVo();
    }

    /**
     * @param $title
     * @param $url
     * @param $params
     * @param $response
     */
    protected function log($title, $url, $params, $response) {
        if ($this->confVo->isLogTrace) {
            LogService::getIns()->trace(JsonUtil::encode([
                "url" => $url,
                "params" => $params,
                "response" => $response,
            ]), $title);
        }
    }

    /**
     * 获取签名 Header 内容
     * @param string $paramsJson 请求参数的json字符串
     * @return string
     * @throws ApiException
     */
    protected function getAuthorizationHeaderItem($paramsJson) {
        return "Authorization:sn " . md5($paramsJson . $this->getTerminalSn());
    }

    /**
     * 请求激活接口
     * @param SqbActivateRequest $request
     * @return SqbActivateResponse
     * @throws ApiException
     */
    protected function requestTerminal_activate(SqbActivateRequest $request) {
        $url = $this->confVo->apiDomain . Sqb::UrlActivate;
        $params = $request->toArray();
        $authorization = $this->getAuthorizationHeaderItem(JsonUtil::encode($params));
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->log("请求：收钱吧-激活", $url, $params, $json);
        return SqbActivateResponse::initByJson($json);
    }

    /**
     * 请求签到接口
     * @param SqbCheckinRequest $request
     * @return SqbCheckinResponse
     * @throws ApiException
     */
    protected function requestTerminal_checkin(SqbCheckinRequest $request) {
        $url = $this->confVo->apiDomain . Sqb::UrlCheckin;
        $params = $request->toArray();
        $authorization = $this->getAuthorizationHeaderItem(JsonUtil::encode($params));
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->log("请求：收钱吧-签到", $url, $params, $json);
        return SqbCheckinResponse::initByJson($json);
    }

    /**
     * 请求支付接口
     * @param SqbPayRequest $request
     * @return SqbPayResponse
     * @throws ApiException
     */
    protected function requestUpay_v2_pay(SqbPayRequest $request) {
        $url = $this->confVo->apiDomain . Sqb::UrlPay;
        $params = $request->toArray();
        $authorization = $this->getAuthorizationHeaderItem(JsonUtil::encode($params));
        $json = HttpUtil::post($url, $params, [$authorization, "Content-type:application/json"]);
        $this->log("请求：收钱吧-支付", $url, $params, $json);
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
            $request = new SqbActivateRequest();
            $request->app_id = $this->confVo->appId;
            $request->code = $this->confVo->code;
            $request->device_id = $this->confVo->deviceId;
            $response = $this->requestTerminal_activate($request);
            if ($response->hasError()) {
                throw new ApiException($response->result_code);
            }
            $terminalSn = $response->biz_response->terminal_sn;
            $terminalKey = $response->biz_response->terminal_key;
            // 缓存信息
            $fileCacheSrv->set(FileCacheKey::SqbTerminalSn, $terminalSn);
            $duration = TimeUtil::getDatEnd() - time(); // 有效时间是今天的 23:59:59
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
            $request = new SqbCheckinRequest();
            $request->terminal_sn = $this->getTerminalSn();
            $request->device_id = $this->confVo->deviceId;
            $response = $this->requestTerminal_checkin($request);
            if ($response->hasError()) {
                throw new ApiException($response->result_code);
            }
            $duration = TimeUtil::getDatEnd() - time(); // 有效时间是今天的 23:59:59
            $terminalKey = $response->biz_response->terminal_key;
            $fileCacheSrv->set(FileCacheKey::SqbTerminalKey, $terminalKey, $duration);
        }
        return $terminalKey;
    }

    /**
     * 调用支付
     * @param string $sn 订单编号
     * @param string $totalAmount 总金额
     * @param string $subject 交易简要概述（如购买了什么商品、服务）
     * @param string $dynamicId 条码内容
     * @param string $payway 支付方式
     * @param SqbPayGoodsDetailVo[] $goodsDetails 商品详情
     * @param string $operator 操作员
     * @return SqbPayResponse
     * @throws ApiException
     */
    public function pay($sn, $totalAmount, $subject, $dynamicId, $payway = null, array $goodsDetails = [], $operator = "") {
        if (empty($operator)) {
            $operator = $this->confVo->defaultOperator;
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
        $request->notify_url = $this->confVo->notifyUrl;

        $response = $this->requestUpay_v2_pay($request);
        if ($request->hasError()) {
            throw new ApiException($response->error_message);
        }

        return $response;
    }
}