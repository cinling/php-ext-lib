<?php


namespace cin\extLib\vos;


use cin\extLib\traits\GeoUtilTrait;

/**
 * Class GeoPosVo 地理位置
 * @package cin\extLib\vos
 */
class GeoPosVo extends BaseVo {
    /**
     * @var float|string 经度
     */
    public $longitude;
    /**
     * @var float|string 纬度
     */
    public $latitude;

    /**
     * @param $longitude
     * @param $latitude
     * @return static
     */
    public static function initBase($longitude, $latitude) {
        $vo = new static();
        $vo->longitude = $longitude;
        $vo->latitude = $latitude;
        return $vo;
    }

    /**
     * @return bool
     */
    public function valid() {
        if (!GeoUtilTrait::isRightPos($this->longitude, $this->latitude)) {
            $this->addError("Illegal latitude and longitude:" . $this->longitude . "," . $this->latitude);
        }
        return parent::valid();
    }
}