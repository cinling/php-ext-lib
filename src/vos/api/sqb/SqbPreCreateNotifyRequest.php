<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\api\BaseNotifyRequest;

/**
 * Class SqbPreCreateNotifyRequest 预付款接口的回调参数
 * @package cin\extLib\vos\api\sqb
 *
 * 原始回调参数参考：{"sn":"7895208834374741","client_sn":"SN202101051840164850","client_tsn":"SN202101051840164850","ctime":"1609843241976","status":"ERROR_RECOVERY","payway":"3","payway_name":"微信","sub_payway":"3","order_status":"PAY_ERROR","total_amount":"2","net_amount":"2","finish_time":"1609843487437","subject":"一站式管家服务","store_id":"5c68576d-f710-e107-41b7-2dd837a1335b","terminal_id":"28a58246-5d75-4c44-a31d-a0db914f5c4c","operator":"系统","payment_list":[]}
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
     * @var string 活动优惠
     */
    public $payment_list;
}