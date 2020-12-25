<?php


namespace cin\extLib\vos\api\wechat;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatGetTicketRequest
 * @package cin\extLib\vos\api\wechat
 */
class WechatGetTicketRequest extends BaseRequest {
    /**
     * @var string accessToken
     */
    public $access_token;
    /**
     * @var string 类型
     */
    public $type = "jsapi";
}