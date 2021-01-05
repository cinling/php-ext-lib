<?php


namespace cin\extLib\vos\config;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbConfVo 收钱吧配置对象
 * @package cin\extLib\vos\config
 */
class SqbConfVo extends BaseApiConfVo {
    /**
     * @var string API请求地址
     */
    public $apiDomain = "https://vsi-api.shouqianba.com";
    /**
     * @var string 从开发者平台获取
     * @see http://op.shouqianba.com/#/vendor-detail
     */
    public $appId;
    /**
     * @var string 服务商序列号
     */
    public $vendorSn;
    /**
     * @var string 服务商密钥
     */
    public $vendorKey;
    /**
     * @var string 激活码内容
     */
    public $code;
    /**
     * @var string 设备id
     */
    public $deviceId;
    /**
     * @var string 默认操作员名字
     */
    public $defaultOperator = "系统";
    /**
     * @var int 签到有效时长
     */
    public $checkinDuration = 86400;
}