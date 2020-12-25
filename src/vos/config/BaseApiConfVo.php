<?php


namespace cin\extLib\vos\config;


use cin\extLib\interfaces\IBaseApiConfVo;
use cin\extLib\vos\BaseVo;

/**
 * Class BaseApiConfVo api服务相关配置的基础配置
 * @package cin\extLib\vos\config
 */
class BaseApiConfVo extends BaseVo implements IBaseApiConfVo {
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