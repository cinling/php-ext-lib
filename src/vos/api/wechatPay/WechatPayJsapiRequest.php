<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class PayJsapiRequest jspi 统一下单接口请求数据
 * @package cin\extLib\vos\api\wechatPay
 * @see https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_1_1.shtml 文档地址
 */
class WechatPayJsapiRequest extends BaseRequest {

    /**
     * @var string 直连商户申请的公众号或移动应用appid。
     */
    public $appid;
    /**
     * @var string 商户id
     */
    public $mchid;
    /**
     * @var string 商品描述
     */
    public $description;
    /**
     * @var string 商户订单号
     */
    public $out_trade_no;
    /**
     * @var string 交易结束时间
     */
    public $time_expire;
    /**
     * @var string 附加数据
     */
    public $attach;
    /**
     * @var string 通知地址
     */
    public $notify_url;
    /**
     * @var string 订单优惠标记
     */
    public $goods_tag;
    /**
     * @var WechatPayJsapiAmount 订单金额
     */
    public $amount;
    /**
     * @var WechatPayJsapiPayer 支付者
     */
    public $payer;

    /**
     * 初始化对象
     */
    public function onInit() {
        parent::onInit();
        $this->amount = new WechatPayJsapiAmount();
        $this->payer = new WechatPayJsapiPayer();
    }
}