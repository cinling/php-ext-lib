<?php


namespace cin\extLib\vos\api\wechatPay;

/**
 * Class WechatPayTransfersResponse
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayTransfersResponse extends BaseWechatPayResponse {
    /**
     * @var string 商户appid
     */
    public $mch_appid;
    /**
     * @var string 商户号
     */
    public $mchid;
    /**
     * @var string 设备号
     */
    public $device_info;
    /**
     * @var string 随机字符串
     */
    public $nonce_str;
    /**
     * @var string 业务结果
     */
    public $result_code;
    /**
     * @var string 错误代码
     */
    public $err_code;
    /**
     * @var string 错误代码描述
     */
    public $err_code_des;
    /**
     * @var string 商户订单号
     */
    public $partner_trade_no;
    /**
     * @var string 微信付款单号
     */
    public $payment_no;
    /**
     * @var string 付款成功时间
     */
    public $payment_time;
}