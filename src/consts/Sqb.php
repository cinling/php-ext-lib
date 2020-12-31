<?php


namespace cin\extLib\consts;

/**
 * Class Sqb 收钱吧相关的常量
 * @package cin\extLib\consts
 */
class Sqb {
    /**
     * 请求链接：激活接口
     */
    const UrlActivate = "/terminal/activate";
    /**
     * 请求链接：签到接口
     */
    const UrlCheckin = "/terminal/checkin";
    /**
     * 请求链接：支付接口
     */
    const UrlPay = "/upay/v2/pay";
    /**
     * 请求链接：预下单
     */
    const UrlPreCreate = "/upay/v2/precreate";

    /**
     * 预下单支付方式：支付宝
     */
    const PreCreatePayWayAli = "2";
    /**
     * 预下单支付方式：微信
     */
    const PreCreatePayWayWechat = "3";

    /**
     * 预付款二级支付方式：WAP
     */
    const PreCreateSubPayWayWap = "3";
    /**
     * 预付款二级支付方式：小程序
     */
    const PreCreateSubPayWayMini = "4";
}