<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatPayUnifiedorderRequest jsapi 统一下单接口请求参数
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayUnifiedorderRequest extends BaseRequest {

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
     * @var string 签名
     */
    public $sign;
    /**
     * @var string 签名类型
     */
    public $sign_type;
    /**
     * @var string 商品描述
     */
    public $body;
    /**
     * @var string 商品详情
     */
    public $detail;
    /**
     * @var string 附加数据
     */
    public $attach;
    /**
     * @var string 商户订单号
     */
    public $out_trade_no;
    /**
     * @var string 标价币种
     */
    public $fee_type;
    /**
     * @var string 订单总金额，单位为分
     */
    public $total_fee;
    /**
     * @var string 终端IP
     */
    public $spbill_create_ip;
    /**
     * @var string 交易起始时间
     */
    public $time_start;
    /**
     * @var string 交易结束时间
     */
    public $time_expire;
    /**
     * @var string 订单优惠标记
     */
    public $goods_tag;
    /**
     * @var string 通知地址
     */
    public $notify_url;
    /**
     * @var string 交易类型
     */
    public $trade_type;
    /**
     * @var string  商品ID
     */
    public $product_id;
    /**
     * @var string 用户标识
     */
    public $openid;
    /**
     * @var string 电子发票入口开放标识
     */
    public $receipt;
    /**
     * @var string 是否需要分账
     */
    public $profit_sharing;
    /**
     * @var mixed 场景信息
     */
    public $scene_info;
}