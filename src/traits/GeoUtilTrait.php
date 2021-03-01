<?php


namespace cin\extLib\traits;


use cin\extLib\consts\Constant;
use cin\extLib\vos\GeoPosVo;

/**
 * Trait GeoUtilTrait 地理位置工具插件
 * @package cin\extLib\traits
 */
trait GeoUtilTrait {
    /**
     * 是否是正确的位置信息
     * @param $longitude
     * @param $latitude
     * @return bool
     */
    public static function isRightPos($longitude, $latitude) {
        return self::isRightLongitude($longitude) && self::isRightLatitude($latitude);
    }

    /**
     * 经度是否是合法的
     * @param $longitude
     * @return bool
     */
    public static function isRightLongitude($longitude) {
        $longitudeFloat = floatval($longitude);
        return $longitude !== "" && ($longitudeFloat >= -180 && $longitudeFloat <= 180);
    }

    /**
     * 纬度是否合法
     * @param $latitude
     * @return bool
     */
    public static function isRightLatitude($latitude) {
        $latitudeFloat = floatval($latitude);
        return $latitude !== "" && ($latitudeFloat >= -90 && $latitudeFloat <= 90);
    }

    /**
     * 计算两个将维度的距离。精确度：98%以上，
     * @param GeoPosVo $vo1
     * @param GeoPosVo $vo2
     * @return float 单位：千米
     */
    public static function comDistance(GeoPosVo $vo1, GeoPosVo $vo2) {
        return Constant::EarthRadius * acos(cos(deg2rad($vo1->latitude)) * cos(deg2rad($vo2->latitude)) * cos(deg2rad($vo1->longitude) - deg2rad($vo2->longitude)) + sin(deg2rad($vo1->latitude)) * sin(deg2rad($vo2->latitude)));
    }
}
