<?php


namespace cin\extLib\vos\api\wechat;


use cin\extLib\vos\BaseVo;

/**
 * Class BaseWxResponse 微信基础结构类
 * @package cin\extLib\vos\api\wechat
 */
class BaseWxResponse extends BaseVo {
    /**
     * @var int 错误代码
     */
    public $errcode;
    /**
     * @var string 错误消息
     */
    public $errmsg;

    /**
     * @return bool
     */
    public function hasError() {
        if (!empty($this->errmsg) && $this->errmsg != "ok") {
            $this->addError($this->errmsg);
        }
        return parent::hasError();
    }
}
