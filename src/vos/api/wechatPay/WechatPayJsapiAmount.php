<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\BaseVo;

/**
 * Class WechatPayJsapiAmount
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayJsapiAmount extends BaseVo {

    /**
     * @var int 订单总金额，单位为分。
     */
    public $total;
    /**
     * @var string 货币类型
     */
    public $currency;
}