<?php


use cin\extLib\utils\GeoUtil;
use PHPUnit\Framework\TestCase;

class GeoUtilTraitTest extends TestCase {

    /**
     * @test
     */
    public function isRightPos() {
        $this->assertTrue(GeoUtil::isRightPos("119.123456", "23.123456"));
        $this->assertTrue(GeoUtil::isRightPos("-180", "-90"));
        $this->assertTrue(GeoUtil::isRightPos("180", "90"));

        $this->assertFalse(GeoUtil::isRightPos("180.0000001", "0"));
        $this->assertFalse(GeoUtil::isRightPos("180.0000001", "-90.1"));
    }
}
