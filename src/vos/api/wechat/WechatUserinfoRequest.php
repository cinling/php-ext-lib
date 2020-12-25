<?php


namespace cin\extLib\vos\api\wechat;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatUserinfoRequest
 * @package cin\extLib\vos\api\wechat
 */
class WechatUserinfoRequest extends BaseRequest {
    /**
     * @var string 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     */
    public $access_token;
    /**
     * @var string 用户的唯一标识
     */
    public $openid;
    /**
     * @var string 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     */
    public $lang = "zh_CN";
}