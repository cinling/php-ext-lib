<?php


namespace cin\extLib\vos\config;


use cin\extLib\vos\BaseVo;

/**
 * Class JsSdkConfigVo
 * @package cin\extLib\vos\config
 */
class JsSdkConfigVo extends BaseVo {
    /**
     * @var string 公众号appId
     */
    public $appId;
    /**
     * @var string 当前时间戳
     */
    public $timestamp;
    /**
     * @var string 随机字符串
     */
    public $nonceStr;
    /**
     * @var string 签名
     */
    public $signature;
}