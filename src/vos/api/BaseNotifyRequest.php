<?php


namespace cin\extLib\vos\api;


use cin\extLib\vos\BaseVo;

/**
 * Class BaseNotifyRequest 基础通知接口（第三方调用并带参数）
 * @package cin\extLib\vos\api
 */
class BaseNotifyRequest extends BaseVo {

    /**
     * 使用 php://input 的数据初始化对象
     * @return static
     */
    public static function initByPhpInputJson() {
        $content = file_get_contents("php://input");
        return static::initByJson($content);
    }
}