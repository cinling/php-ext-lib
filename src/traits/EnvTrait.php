<?php


namespace cin\extLib\traits;


trait EnvTrait {

    /**
     * @return bool 是否 windows 系统
     */
    public static function isWindows() {
        return strtoupper(substr(PHP_OS,0,3))==='WIN';
    }
}