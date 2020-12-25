<?php


namespace cin\extLib\vos\api\wechat;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class WechatMediaGetRequest
 * @package cin\extLib\vos\api\wechat
 */
class WechatMediaGetRequest extends BaseRequest {

    /**
     * @var string 调用接口凭证
     */
    public $access_token;
    /**
     * @var string 媒体文件ID
     */
    public $media_id;
}