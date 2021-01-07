<?php


namespace cin\extLib\consts;

/**
 * Class WechatPay 微信支付常量
 * @package cin\extLib\consts
 */
class WechatPay {
    /**
     * jsapi 统一下单
     */
    const UrlPayJsapi = "https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi";

    /**
     * 货币类型：人民币 CNY
     */
    const CurrencyCny = "CNY";
}