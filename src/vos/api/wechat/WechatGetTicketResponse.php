<?php


namespace cin\extLib\vos\api\wechat;


/**
 * Class WechatGetTicketResponse
 * @package cin\extLib\vos\api\wechat
 */
class WechatGetTicketResponse extends BaseWechatResponse {
    /**
     * @var string token
     */
    public $ticket;
    /**
     * @var int 有效期时长（秒数）
     */
    public $expires_in;
}