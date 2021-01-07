<?php


namespace cin\extLib\cos;


/**
 * Class WechatPayCo
 * @package cin\extLib\cos
 */
class WechatPayCo extends BaseCo {

    /**
     * @var string 商户号
     */
    public $mchId;
    /**
     * @var string 支付密钥
     */
    public $secret;
    /**
     * @var string 支付证书
     */
    public $pemCert;
    /**
     * @var string 支付证书密钥
     */
    public $pemKey;
}