<?php


namespace cin\extLib\vos\api\wechat;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatRefreshTokenRequest
 * @package cin\extLib\vos\api\wechat
 */
class WechatRefreshTokenRequest extends BaseRequest {
    /**
     * @var string 微信appid
     */
    public $appid;
    /**
     * @var string 公众号的唯一标识
     */
    public $grant_type = "refresh_token";
    /**
     * @var string 填写通过access_token获取到的refresh_token参数
     */
    public $refresh_token;
}