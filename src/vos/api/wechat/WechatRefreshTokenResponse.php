<?php


namespace cin\extLib\vos\api\wechat;


/**
 * Class WechatRefreshTokenResponse
 * @package cin\extLib\vos\api\wechat
 */
class WechatRefreshTokenResponse extends BaseWechatResponse {
    /**
     * @var string 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     */
    public $access_token;
    /**
     * @var string access_token接口调用凭证超时时间，单位（秒）
     */
    public $expires_in;
    /**
     * @var string 用户刷新access_token
     */
    public $refresh_token;
    /**
     * @var string 用户唯一标识
     */
    public $openid;
    /**
     * @var string 用户授权的作用域，使用逗号（,）分隔
     */
    public $scope;
}