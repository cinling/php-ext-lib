<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\BaseVo;

/**
 * Class WechatPayJsapiResponse
 * @package cin\extLib\vos\api\wechatPay
 */
class WechatPayJsapiResponse extends BaseVo {
    /**
     * @var string 返回代码
     */
    public $code;
    /**
     * @var string 错误信息
     */
    public $message;
    /**
     * @var string 预支付交易会话标识。用于后续接口调用中使用，该值有效期为2小时
     */
    public $prepay_id;

    public function hasError() {
        if (!empty($this->message)) {
            $this->addError($this->message);
        }
        return parent::hasError();
    }
}