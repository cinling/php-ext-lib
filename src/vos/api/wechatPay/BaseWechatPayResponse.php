<?php


namespace cin\extLib\vos\api\wechatPay;


use cin\extLib\vos\BaseVo;

/**
 * Class BaseWechatPayResponse
 * @package cin\extLib\vos\api\wechatPay
 */
class BaseWechatPayResponse extends BaseVo {
    /**
     * @var string 返回状态码
     */
    public $return_code;
    /**
     * @var string 返回信息
     */
    public $return_msg;
}