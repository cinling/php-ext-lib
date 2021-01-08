<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\BaseVo;

/**
 * Class WechatPayUnifiedorderResponse
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayUnifiedorderResponse extends BaseVo {

    /**
     * @var string 返回状态码
     */
    public $return_code;
    /**
     * @var string 返回信息
     */
    public $return_msg;
    /**
     * @var string 公众账号ID
     */
    public $appid;
    /**
     * @var string 商户号
     */
    public $mch_id;
    /**
     * @var string 设备号
     */
    public $device_info;
    /**
     * @var string 随机字符串
     */
    public $nonce_str;
    /**
     * @var string 微信返回的签名值
     */
    public $sign;
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
     * @var string 交易类型
     */
    public $trade_type;
    /**
     * @var string 预支付交易会话标识
     */
    public $prepay_id;
    /**
     * @var string 二维码链接
     */
    public $code_url;
}