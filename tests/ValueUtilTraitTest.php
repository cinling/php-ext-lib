<?php

use cin\extLib\traits\ValueUtilTrait;
use PHPUnit\Framework\TestCase;


/**
 * Class ValueUtilTraitTest
 */
class ValueUtilTraitTest extends TestCase {

    /**
     * @test
     */
    public function toInt() {
        $this->assertTrue(1 === ValueUtilTrait::toInt("1"));
        $this->assertTrue(223311 === ValueUtilTrait::toInt("223311"));
        $this->assertTrue(1 === ValueUtilTrait::toInt("1.123"));
        $this->assertTrue(-123123 === ValueUtilTrait::toInt("-123123"));
    }

    /**
     * @test
     */
    public function toBool() {
        $this->assertTrue(ValueUtilTrait::toBool("true"));
        $this->assertTrue(ValueUtilTrait::toBool("1"));
        $this->assertTrue(ValueUtilTrait::toBool(1));
        $this->assertTrue(ValueUtilTrait::toBool(true));
        $this->assertFalse(ValueUtilTrait::toBool(false));
        $this->assertFalse(ValueUtilTrait::toBool("false"));
        $this->assertFalse(ValueUtilTrait::toBool("0"));
        $this->assertFalse(ValueUtilTrait::toBool(0));
        $this->assertFalse(ValueUtilTrait::toBool(null));
    }

    /**
     * @test
     */
    public function getValue() {
        $dict = [
            "a" => "A1",
            "b" => "B2",
            "c" => "C3",
        ];

        $this->assertEquals("A1", ValueUtilTrait::getValue($dict, "a"));
        $this->assertEquals("B2", ValueUtilTrait::getValue($dict, "b"));
        $this->assertEquals("", ValueUtilTrait::getValue($dict, "d"));
        $this->assertEquals("default", ValueUtilTrait::getValue($dict, "d", "default"));
    }
}
