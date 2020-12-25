<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbPayResponse
 * @package cin\extLib\vos\api\sqb
 */
class SqbPayResponse extends BaseVo {
    /**
     * @var string 结果码
     * @note 结果码表示接口调用的业务逻辑是否成功
     * @example "PAY_SUCCESS"
     */
    public $result_code;
    /**
     * @var string 错误码
     * @note 参考附录：业务执行错误码列表
     */
    public $error_code;
    /**
     * @var string 错误消息
     */
    public $error_message;
    /**
     * @var string 终端编号
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
     * @var string 本次操作金额
     */
    public $settlement_amount;
    /**
     * @var string 交易概述
     */
    public $subject;
    /**
     * @var string 付款动作在收钱吧的完成时间
     */
    public $finish_time;
}