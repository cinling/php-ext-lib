<?php


namespace cin\extLib\vos\api\wechat;


/**
 * Class WxJsSdkAccessTokenResponse 微信获取 access_token 的返回数据
 * 返回示例：
 *  {
 *      "access_token":"ACCESS_TOKEN",
 *      "expires_in":7200,
 *      "refresh_token":"REFRESH_TOKEN",
 *      "openid":"OPENID",
 *      "scope":"SCOPE"
 *  }
 *
 * @package cin\extLib\vos\api\wechat
 */
class WechatAccessTokenResponse extends BaseWechatResponse {
    /**
     * @var string 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     */
    public $access_token;
    /**
     * @var int access_token接口调用凭证超时时间，单位（秒）
     */
    public $expires_in;
    /**
     * @var string 用户刷新access_token
     */
    public $refresh_token;
    /**
     * @var string 用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
     */
    public $openid;
    /**
     * @var string 用户授权的作用域，使用逗号（,）分隔
     */
    public $scope;
}