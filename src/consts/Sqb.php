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
     * 支付方式：支付宝
     */
    const PayWayAli = "2";
    /**
     * 支付方式：微信
     */
    const PayWayWechat = "3";

    /**
     * 二级支付方式：二维码支付
     */
    const SubPayWayQrCode = "2";
    /**
     * 二级支付方式：WAP
     */
    const SubPayWayWap = "3";
    /**
     * 二级支付方式：小程序
     */
    const SubPayWayMini = "4";
    /**
     * 二级支付方式：APP支付
     */
    const SubPayWayApp = "5";
    /**
     * 二级支付方式：H5支付
     */
    const SubPayWayH5 = 6;
}