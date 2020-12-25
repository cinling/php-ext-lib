<?php


namespace cin\extLib\vos\api\wechat;



use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatAccessTokenRequest 微信获取js-sdk的请求参数
 * @package cin\extLib\vos\api\wechat
 */
class WechatAccessTokenRequest extends BaseRequest {
    /**
     * @var string 公众号的唯一标识
     */
    public $appid;
    /**
     * @var string 公众号的appsecret
     */
    public $secret;
    /**
     * @var string 前端的jscode
     */
    public $code;
    /**
     * @var string
     */
    public $grant_type = "authorization_code";
}