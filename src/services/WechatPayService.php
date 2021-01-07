<?php


namespace cin\extLib\services;

use cin\extLib\consts\Wechat;
use cin\extLib\consts\WechatPay;
use cin\extLib\cos\WechatPayCo;
use cin\extLib\traits\SingleTrait;

/**
 * Class WechatPayService
 * 微信支付、微信商户号 服务
 * @package cin\extLib\services
 */
class WechatPayService {
    use SingleTrait;

    /**
     * @var WechatPayCo
     */
    protected $co;

    /**
     * WechatPayService constructor.
     */
    protected function __construct() {
        $this->co = new WechatPayCo();
    }

    /**
     * @param string $appId 公众号appid
     * @param string $description 商品描述
     * @param string $notifyUrl 通知地址
     * @param string $out_trade_no 订单编号
     * @param string $openid 付款人openid
     * @param int $total 总价。单位：分
     * @param string $currency 货币类型
     */
    protected function requestV3_pay_transactions_jsapi($appId, $description, $notifyUrl, $out_trade_no, $openid, $total, $currency = WechatPay::CurrencyCny, $extParams = []) {

    }
}