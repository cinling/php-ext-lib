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
}