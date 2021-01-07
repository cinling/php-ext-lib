<?php


namespace cin\extLib\services;

use cin\extLib\consts\Wechat;
use cin\extLib\consts\WechatPay;
use cin\extLib\cos\WechatPayCo;
use cin\extLib\traits\ApiTractLogTrait;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\HttpUtil;
use cin\extLib\utils\StringUtil;
use cin\extLib\utils\UrlUtil;
use cin\extLib\vos\api\wechatPay\WechatPayJsapiRequest;
use cin\extLib\vos\api\wechatPay\WechatPayJsapiResponse;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;

/**
 * Class WechatPayService
 * 微信支付、微信商户号 服务
 * @package cin\extLib\services
 * @deprecated
 */
class WechatPayService {
    use SingleTrait;
    use ApiTractLogTrait;

    /**
     * @var WechatPayCo
     */
    protected $co;

    /**
     * WechatPayService constructor.
     */
    protected function __construct() {
        $this->co = new WechatPayCo();
        $this->setBaseApiConfVo($this->co);
    }

    /**
     * jsapi 统一下单接口
     * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1
     */
    protected function requestPay_unifiedorder($appid) {

    }
}