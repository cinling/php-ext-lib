<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbPayGoodsDetailVo
 * @package cin\extLib\vos\api\sqb
 */
class SqbPayGoodsDetailVo extends BaseVo {
    /**
     * @var string 商品的编号
     */
    public $goods_id;
    /**
     * @var string 商品名称，如ipad
     */
    public $goods_name;
    /**
     * @var int 商品数量，如10
     */
    public $quantity;
    /**
     * @var int 商品单价，单位为分，如2000
     */
    public $price;
    /**
     * @var int 优惠类型，0表示没有优惠，1表示支付机构优惠，为1会把相关信息送到支付机构
     */
    public $promotion_type;
}