<?php


namespace cin\extLib\vos\config;


use cin\extLib\vos\BaseVo;

/**
 * Class WechatConfVo
 * @package cin\extLib\vos\config
 */
class WechatConfVo extends BaseApiConfVo {
    /**
     * @var string 公众号 appid
     */
    public $appId;
    /**
     * @var string 公众号 Secret
     */
    public $appSecret;
}