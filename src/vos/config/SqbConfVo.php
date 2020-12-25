<?php


namespace cin\extLib\vos\config;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbConfVo 收钱吧配置对象
 * @package cin\extLib\vos\config
 */
class SqbConfVo extends BaseVo {
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
     * @var string 激活码内容
     */
    public $code;
    /**
     * @var string 设备id
     */
    public $deviceId = "一站式管家-锋火后台";
    /**
     * @var string 支付成功后的回调地址
     */
    public $notifyUrl;
    /**
     * @var bool 是否打印日志记录接口请求情况
     */
    public $isLogTrace = true;
    /**
     * @var string 默认操作员名字
     */
    public $defaultOperator = "系统";
}