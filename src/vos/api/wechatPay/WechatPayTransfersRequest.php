<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatPayTransfersRequest
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayTransfersRequest extends BaseRequest {

    /**
     * @var string 商户账号appid
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
     * @var string 签名
     */
    public $sign;
    /**
     * @var string 商户订单号
     */
    public $partner_trade_no;
    /**
     * @var string 用户openid
     */
    public $openid;
    /**
     * @var string 校验用户姓名选项
     */
    public $check_name;
    /**
     * @var string 收款用户姓名
     */
    public $re_user_name;
    /**
     * @var string 企业付款金额，单位为分
     */
    public $amount;
    /**
     * @var string 企业付款备注
     */
    public $desc;
    /**
     * @var string Ip地址
     * @note 该IP同在商户平台设置的IP白名单中的IP没有关联，该IP可传用户端或者服务端的IP。
     */
    public $spbill_create_ip;
}