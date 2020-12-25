<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\api\BaseRequest;

/**
 * Class SqbCheckinRequest
 * @package cin\extLib\vos\api\sqb
 */
class SqbCheckinRequest extends BaseRequest {

    /**
     * @var string 终端id
     */
    public $terminal_sn;
    /**
     * @var string 设备唯一身份ID
     */
    public $device_id;
    /**
     * @var string 当前系统信息，如: Android5.0
     */
    public $os_info;
    /**
     * @var string SDK版本
     */
    public $sdk_version;
}