<?php


namespace cin\extLib\consts;

/**
 * Class WechatPay 微信支付常量
 * @package cin\extLib\consts
 */
class WechatPay {
    /**
     * 请求地址： 平台证书申请(V3)
     */
    const UrlCert = "https://api.mch.weixin.qq.com/v3/certificates";
    /**
     * 请求地址：jsapi 统一下单（V3）
     */
    const UrlPayJsapi = "https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi";
    /**
     * 请求地址：jsapi 统一下单接口
     */
    const UrlJsapiUnifiedorder = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    /**
     * 企请求地址：业转账至个人。提现功能
     */
    const UrlTransfers = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";

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

    /**
     * 校验用户姓名选项：不校验真实姓名
     */
    const CheckNameNo = "NO_CHECK";
    /**
     * 校验用户姓名选项：强校验真实姓名
     */
    const CheckNameForce = "FORCE_CHECK";
}