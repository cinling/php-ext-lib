<?php


use cin\extLib\traits\GeoUtilTrait;
use cin\extLib\vos\GeoPosVo;
use PHPUnit\Framework\TestCase;


class GeoUtilTraitTest extends TestCase {

    /**
     * @test
     */
    public function comDistance() {
        $expMin = 0.88;
        $expMax = 1.98; // 地图约 9.3
        $act = GeoUtilTrait::comDistance(
            GeoPosVo::initBase(113.389742, 23.130908),
            GeoPosVo::initBase(113.395514, 23.124436)
        );
        $this->assertTrue($act > $expMin && $act < $expMax);

        $expMin = 80;
        $expMax = 81; // 地图约 80.5
        $act = GeoUtilTrait::comDistance(
            GeoPosVo::initBase(113.395901, 23.124337),
            GeoPosVo::initBase(113.880157, 22.554574)
        );
        $this->assertTrue($act > $expMin && $act < $expMax);


        $expMin = 1885;
        $expMax = 1895; // 地图约 1890
        $act = GeoUtilTrait::comDistance(
            GeoPosVo::initBase(113.395901, 23.124337),
            GeoPosVo::initBase(116.427269, 39.904979)
        );
        $this->assertTrue($act > $expMin && $act < $expMax);
    }
}