<?php


use cin\extLib\traits\GeoUtilTrait;
use PHPUnit\Framework\TestCase;

class GeoUtilTraitTest extends TestCase {

    /**
     * @test
     */
    public function isRightPos() {
        $this->assertTrue(GeoUtilTrait::isRightPos("119.123456", "23.123456"));
        $this->assertTrue(GeoUtilTrait::isRightPos("-180", "-90"));
        $this->assertTrue(GeoUtilTrait::isRightPos("180", "90"));

        $this->assertFalse(GeoUtilTrait::isRightPos("180.0000001", "0"));
        $this->assertFalse(GeoUtilTrait::isRightPos("180.0000001", "-90.1"));
    }
}
