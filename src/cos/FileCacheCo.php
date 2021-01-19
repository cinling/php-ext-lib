<?php


namespace cin\extLib\cos;


/**
 * Class FileCacheCo
 * File cache service configuration
 * @package cin\extLib\cos
 */
class FileCacheCo extends BaseCo {
    /**
     * @var string Save the directory. The default is the relative path of the entry file
     */
    public $path = "./runtime/cin-cache";
    /**
     * @var int Path depth
     */
    public $pathDeeps = 2;
    /**
     * @var int The number of characters in a single directory.
     * @note $pathDeeps * $pathUnitLen <= 64
     */
    public $pathUnitLen = 2;
}