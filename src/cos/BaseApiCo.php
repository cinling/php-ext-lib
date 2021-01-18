<?php


namespace cin\extLib\cos;


use cin\extLib\interfaces\IBaseApiCo;

/**
 * Class BaseApiCo
 * @package cin\extLib\cos
 */
class BaseApiCo extends BaseCo implements IBaseApiCo {
    /**
     * @var string 支付成功后的回调地址
     */
    public $notifyUrl;
    /**
     * @var bool 是否打印日志记录接口请求情况
     */
    public $isLogTrace = true;

    /**
     * @return bool
     */
    public function isLogTrace() {
        return $this->isLogTrace;
    }
}