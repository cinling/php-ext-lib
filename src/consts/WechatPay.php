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
}