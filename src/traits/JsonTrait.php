<?php


namespace cin\extLib\traits;

/**
 * Trait JsonTrait
 * @package cin\extLib\traits
 */
trait JsonTrait {

    /**
     * @param mixed $value
     * @param int $flags
     * @return string
     */
    public static function encode($value, $flags = JSON_UNESCAPED_UNICODE) {
        return json_encode($value, $flags);
    }

    /**
     * 美化的格式输出json
     * @param $value
     * @return string
     */
    public static function encodePretty($value) {
        return static::encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * @param $json
     * @return array
     */
    public static function decode($json) {
        return json_decode($json, true);
    }
}