<?php


namespace cin\extLib\vos;


use cin\extLib\services\FileCacheService;

/**
 * Class FileCacheConfigVo 文件服务配置
 * @package cin\extLib\vos
 * @see FileCacheService
 * @deprecated 即将使用 cos 包代替
 */
class FileCacheConfigVo extends BaseVo {
    /**
     * @var string 保存目录。默认是入口文件的相对路径
     */
    public $path = "./runtime/cin-cache";
    /**
     * @var int 目录深度
     */
    public $pathDeeps = 2;
    /**
     * @var int 单目录的字符数。注意： $pathDeeps * $pathUnitLen <= 64
     */
    public $pathUnitLen = 2;
}