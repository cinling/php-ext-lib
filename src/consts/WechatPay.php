<?php


namespace cin\extLib\consts;

/**
 * Class WechatPay 微信支付常量
 * @package cin\extLib\consts
 */
class WechatPay {
    /**
     * 平台证书申请
     */
    const UrlCert = "https://api.mch.weixin.qq.com/v3/certificates";
    /**
     * jsapi 统一下单
     */
    const UrlPayJsapi = "https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi";
    /**
     * jsapi 统一下单接口
     */
    const UrlJsapiUnifiedorder = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    /**
     * 货币类型：人民币 CNY
     */
    const CurrencyCny = "CNY";

    /**
     * 返回码：成功
     */
    const ResponseCodeSuccess = "SUCCESS";
    /**
     * 返回码：失败
     */
    const ResponseCodeFail = "FAIL";

    /**
     * 业务返回码：成功
     */
    const ResultCodeSuccess = "SUCCESS";
    /**
     * 业务返回码：失败
     */
    const ResultCodeFail = "FAIL";

    /**
     * 业务返回码：成功
     */
    const ReturnCodeSuccess = "SUCCESS";
    /**
     * 业务返回码：失败
     */
    const ReturnCodeFail = "FAIL";
}