<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

class SqbPreCreateResponse extends BaseVo {

    /**
     * @var string 收钱吧唯一订单号
     */
    public $sn;
    /**
     * @var string 商户订单号
     */
    public $client_sn;
    /**
     * @var string 支付服务商订单号
     */
    public $trade_no;
    /**
     * @var string 流水状态
     */
    public $status;
    /**
     * @var string 订单状态
     */
    public $order_status;
    /**
     * @var string 支付方式
     */
    public $payway;
    /**
     * @var string 二级支付方式
     */
    public $sub_payway;
    /**
     * @var string 二维码内容
     */
    public $qr_code;
    /**
     * @var string 交易总额
     */
    public $total_amount;
    /**
     * @var string 实收金额
     */
    public $net_amount;
    /**
     * @var string 交易概述
     */
    public $subject;
    /**
     * @var string 操作员
     */
    public $operator;
    /**
     * @var string 反射参数/透传参数
     */
    public $reflect;
    /**
     * @var string 支付通道返回的调用WAP支付需要传递的信息
     */
    public $wap_pay_request;
}