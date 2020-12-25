<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbActivateRequest
 * @package cin\extLib\vos\api\sqb
 */
class SqbActivateRequest extends BaseVo {

    /**
     * @var string app_id，从开发者平台获取
     */
    public $app_id;
    /**
     * @var string 激活码内容
     */
    public $code;
    /**
     * @var string 内容自行定义，同一个app_id下唯一。为了方便识别，建议具有一定的格式。例：品牌名称+支付场景
     */
    public $device_id;
    /**
     * @var string 第三方终端号，必须保证在app id下唯一
     */
    public $client_sn;
    /**
     * @var string 终端名
     */
    public $name;
    /**
     * @var string 当前系统信息，如: Android5.0
     */
    public $os_info;
    /**
     * @var string 	SDK版本
     */
    public $sdk_version;
}