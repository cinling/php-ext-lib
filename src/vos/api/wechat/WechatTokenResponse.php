<?php


namespace cin\extLib\vos\api\wechat;

/**
 * Class WechatTokenResponse
 * @package cin\extLib\vos\api\wechat
 */
class WechatTokenResponse extends BaseWechatResponse {
    /**
     * @var string 获取到的凭证
     */
    public $access_token;
    /**
     * @var string 凭证有效时间，单位：秒
     */
    public $expires_in;
}