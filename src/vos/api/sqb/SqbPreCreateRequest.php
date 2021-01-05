<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\consts\Sqb;
use cin\extLib\vos\api\BaseRequest;

/**
 * Class SqbPreCreateRequest 预付款请求参数
 * @package cin\extLib\vos\api\sqb
 */
class SqbPreCreateRequest extends BaseRequest {

    /**
     * @var string 收钱吧终端ID
     */
    public $terminal_sn;
    /**
     * @var string 商户系统订单号
     */
    public $client_sn;
    /**
     * @var string 交易总金额。单位：分
     */
    public $total_amount;
    /**
     * @var string 支付方式
     * @see Sqb 相关常量
     */
    public $payway;
    /**
     * @var string 二级支付方式
     */
    public $sub_payway;
    /**
     * @var string 付款人id
     */
    public $payer_uid;
    /**
     * @var string 交易简介
     */
    public $subject;
    /**
     * @var string 门店操作员
     */
    public $operator;
    /**
     * @var string 商品详情
     */
    public $description;
    /**
     * @var string 经度。经纬度必须同时出现
     */
    public $longitude;
    /**
     * @var string 纬度。经纬度必须同时出现
     */
    public $latitude;
    /**
     * @var string 扩展参数集合
     */
    public $extended;
    /**
     * @var SqbPayGoodsDetailVo[] 商品详情
     */
    public $goods_details;
    /**
     * @var string 反射参数
     */
    public $reflect;
    /**
     * @var string 回调地址
     */
    public $notify_url;

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->goods_details = SqbPayGoodsDetailVo::initList($this->goods_details);
    }
}