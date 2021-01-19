<?php


namespace cin\extLib\cos;


/**
 * Class LogCo
 * LogService Config
 * @package cin\extLib\cos
 */
class LogCo extends BaseCo {
    /**
     * @var string Log file save path. The default is the relative path of the entry file
     */
    public $path = "./runtime/cin-log";
    /**
     * @var integer The maximum length of a single file. Unit: byte. Default 2MB
     * @note When the file is larger than this value, it will be renamed to "cin_{Ymd}_{His}.Log"
     */
    public $fileMaxSize = 2097152;
}