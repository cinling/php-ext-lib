<?php


namespace cin\extLib\vos\api\wechat;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatTokenRequest
 * @package cin\extLib\vos\api\wechat
 */
class WechatTokenRequest extends BaseRequest {
    /**
     * @var string 获取access_token填写client_credential
     */
    public $grant_type = "client_credential";
    /**
     * @var string 第三方用户唯一凭证
     */
    public $appid;
    /**
     * @var string 第三方用户唯一凭证密钥，即appsecret
     */
    public $secret;
}