<?php

use cin\extLib\utils\ValueUtil;
use PHPUnit\Framework\TestCase;


/**
 * Class ValueUtilTraitTest
 */
class ValueUtilTest extends TestCase {

    /**
     * @test
     */
    public function toInt() {
        $this->assertTrue(1 === ValueUtil::toInt("1"));
        $this->assertTrue(223311 === ValueUtil::toInt("223311"));
        $this->assertTrue(1 === ValueUtil::toInt("1.123"));
        $this->assertTrue(-123123 === ValueUtil::toInt("-123123"));
    }

    /**
     * @test
     */
    public function toBool() {
        $this->assertTrue(ValueUtil::toBool("true"));
        $this->assertTrue(ValueUtil::toBool("1"));
        $this->assertTrue(ValueUtil::toBool(1));
        $this->assertTrue(ValueUtil::toBool(true));
        $this->assertFalse(ValueUtil::toBool(false));
        $this->assertFalse(ValueUtil::toBool("false"));
        $this->assertFalse(ValueUtil::toBool("0"));
        $this->assertFalse(ValueUtil::toBool(0));
        $this->assertFalse(ValueUtil::toBool(null));
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

        $this->assertEquals("A1", ValueUtil::getValue($dict, "a"));
        $this->assertEquals("B2", ValueUtil::getValue($dict, "b"));
        $this->assertEquals("", ValueUtil::getValue($dict, "d"));
        $this->assertEquals("default", ValueUtil::getValue($dict, "d", "default"));
    }
}
