<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\consts\WechatPay;
use cin\extLib\vos\BaseVo;

/**
 * Class WechatPayUnifiedorderNotifyResponse 通知返回。通知微信处理的结果
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayUnifiedorderNotifyResponse extends BaseVo {

    /**
     * @var string SUCCESS/FAIL SUCCESS表示商户接收通知成功并校验成功
     */
    public $return_code;
    /**
     * @var string 返回信息，如非空，为错误原因
     */
    public $return_msg;

    /**
     * @return string
     */
    public static function doneAsXml() {
        $vo = new WechatPayUnifiedorderResponse();
        $vo->result_code = WechatPay::ReturnCodeSuccess;
        return $vo->toXml();
    }

    /**
     * @param $returnMsg
     * @return string
     */
    public static function failAsXml($returnMsg) {
        $vo = new WechatPayUnifiedorderResponse();
        $vo->result_code = WechatPay::ReturnCodeFail;
        $vo->return_msg = $returnMsg;
        return $vo->toXml();
    }
}