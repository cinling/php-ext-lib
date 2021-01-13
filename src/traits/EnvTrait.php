<?php


namespace cin\extLib\traits;


trait EnvTrait {

    /**
     * @return bool 是否 windows 系统
     */
    public static function isWindows() {
        return strtoupper(substr(PHP_OS,0,3))==='WIN';
    }

    /**
     * 是否是 php5.6 版本
     * @return bool
     */
    public static function isPhp56() {
        return PHP_VERSION_ID >= 50600 && PHP_VERSION_ID < 70000;
    }

    /**
     * 是否是 php7
     * @return bool
     */
    public static function isPhp7() {
        return PHP_VERSION_ID >= 70000 && PHP_VERSION_ID < 80000;
    }

    /**
     * 是否大于或等于 php7.0 版本
     * @return bool
     */
    public static function isGtePhp70() {
        return PHP_VERSION_ID >= 70000;
    }

    /**
     * 是否大于或等于 php7.1 版本
     * @return bool
     */
    public static function isGtePhp71() {
        return PHP_VERSION_ID >= 70100;
    }

    /**
     * 是否大于或等于 php7.1 版本
     * @return bool
     */
    public static function isGtePhp72() {
        return PHP_VERSION_ID >= 70200;
    }

    /**
     * 是否大于或等于 php7.1 版本
     * @return bool
     */
    public static function isGtePhp73() {
        return PHP_VERSION_ID >= 70300;
    }

    /**
     * 是否大于或等于 php7.1 版本
     * @return bool
     */
    public static function isGtePhp74() {
        return PHP_VERSION_ID >= 70400;
    }

    /**
     * 是否大于或等于 php7.1 版本
     * @return bool
     */
    public static function isGtePhp80() {
        return PHP_VERSION_ID >= 80000;
    }
}