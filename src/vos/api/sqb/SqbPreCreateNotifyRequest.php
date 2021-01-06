<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\api\BaseNotifyRequest;

/**
 * Class SqbPreCreateNotifyRequest 预付款接口的回调参数。【注意：根据不同的请求，返回参数会有所不同，这里仅列举官方文档中的返回参数】
 * @package cin\extLib\vos\api\sqb
 */
class SqbPreCreateNotifyRequest extends BaseNotifyRequest {

    /**
     * @var string 终端号
     */
    public $terminal_sn;
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
     * @var string 支付方式名称
     */
    public $payway_name;
    /**
     * @var string 二级支付方式
     */
    public $sub_payway;
    /**
     * @var string 付款人ID
     */
    public $payer_uid;
    /**
     * @var string 付款人账号
     */
    public $payer_login;
    /**
     * @var string 交易总额。单位：分
     */
    public $total_amount;
    /**
     * @var string 实收金额。单位：分
     */
    public $net_amount;
    /**
     * @var string 交易概述
     */
    public $subject;
    /**
     * @var string 付款动作在收钱吧的完成时间。时间戳（毫秒）
     */
    public $finish_time;
    /**
     * @var string 付款动作在支付服务商的完成时间。时间戳（毫秒）
     */
    public $channel_finish_time;
    /**
     * @var string 操作员
     */
    public $operator;
    /**
     * @var string 反射参数
     */
    public $reflect;
    /**
     * @var mixed 活动优惠
     */
    public $payment_list;
}