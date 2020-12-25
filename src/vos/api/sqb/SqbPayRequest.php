<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class SqbPayRequest 收钱吧支付接口请求参数
 * @package cin\extLib\vos\api\sqb
 *
 * @see https://doc.shouqianba.com/zh-cn/api/interface/pay.html 文档链接
 */
class SqbPayRequest extends BaseRequest {

    /**
     * @var string 收钱吧终端ID
     * @note 不超过32位的纯数字
     * @example "00101010029201012912"
     */
    public $terminal_sn;
    /**
     * @var string 商户系统订单号
     * @note 必须在商户系统内唯一；且长度不超过32字节
     * @example "18348290098298292838"
     */
    public $client_sn;
    /**
     * @var string 交易总金额
     * @note 以分为单位,不超过10位纯数字字符串,超过1亿元的收款请使用银行转账
     * @example "1000"
     */
    public $total_amount;
    /**
     * @var string 支付方式
     * @note 非必传。内容为数字的字符串。一旦设置，则根据支付码判断支付通道的逻辑失效
     *          1:支付宝
     *          3:微信
     *          4:百度钱包
     *          5:京东钱包
     *          6:qq钱包
     */
    public $payway;
    /**
     * @var string 条码内容
     * @note 不超过32字节
     * @example "130818341921441147"
     */
    public $dynamic_id;
    /**
     * @var string 交易简介
     * @note 本次交易的简要介绍
     * @example "Pizza"
     */
    public $subject;
    /**
     * @var string 门店操作员
     * @note 发起本次交易的操作员
     * @example "Obama"
     */
    public $operator;
    /**
     * @var string 商品详情
     */
    public $description;
    /**
     * @var string 经度
     */
    public $longitude;
    /**
     * @var string 纬度
     */
    public $latitude;
    /**
     * @var string 设备指纹
     */
    public $device_id;
    /**
     * @var mixed 扩展参数集合
     * @note 收钱吧与特定第三方单独约定的参数集合,json格式，最多支持24个字段，每个字段key长度不超过64字节，value长度不超过256字节 扫码点餐订单必传参数：{"attach":"OrderSource=FoodOrder"}
     * @example { "goods_tag": "beijing"}
     */
    public $extended;
    /**
     * @var SqbPayGoodsDetailVo[]
     * @note 格式为json goods_details的值为数组，每一个元素包含五个字段，goods_id商品的编号，goods_name商品名称，quantity商品数量，price商品单价，单位为分，promotion_type优惠类型，0:没有优惠 1: 支付机构优惠，为1会把相关信息送到支付机构
     * @example "goods_details": [{"goods_id": "wx001","goods_name": "苹果笔记本电脑","quantity": 1,"price": 2,"promotion_type": 0},{"goods_id":"wx002","goods_name":"tesla","quantity": 1,"price": 2,"promotion_type":1}]
     */
    public $goods_details = [];
    /**
     * @var string 反射参数
     * @note 任何调用者希望原样返回的信息，可以用于关联商户ERP系统的订单或记录附加订单内容
     * @example "{ "tips": "200" }"
     */
    public $reflect;
    /**
     * @var string 回调
     * @note 支付回调的地址 例如：www.baidu.com 如果支付成功通知时间间隔为1s,5s,30s,600s
     */
    public $notify_url;
}