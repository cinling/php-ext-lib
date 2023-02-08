<?php


use cin\extLib\traits\StringTrait;
use cin\extLib\utils\StringUtil;
use PHPUnit\Framework\TestCase;

/**
 * Class StringTrait
 */
class StringTraitTest extends TestCase {

    /**
     * @test
     */
    public function has() {
        $this->assertTrue(StringUtil::has("abcdefg", "cde"));
        $this->assertFalse(StringUtil::has("abcdefg", "aa"));
        $this->assertTrue(StringUtil::has("一二三四", "一"));
    }

    /**
     * @test
     */
    public function startWidth() {
        $str = "abc.abc.com";
        $this->assertTrue(StringUtil::startWith($str, "abc."));
    }

    /**
     * @test
     */
    public function endWidth() {
        $str = "www.abc.com";
        $this->assertTrue(StringUtil::endWith($str, ".com"));

        $str = "www.abc.abc";
        $this->assertTrue(StringUtil::endWith($str, ".abc"));
    }

    /**
     * @test
     */
    public function trimLeft() {
        $str = "/www/crm/runtime";
        $this->assertEquals("runtime", StringUtil::trimLeft($str, "/www/crm/"));

        $str = "/www/www/www/abc";
        $this->assertEquals("/abc", StringUtil::trimLeft($str, "/www"));
        $this->assertEquals("/www/www/abc", StringUtil::trimLeft($str, "/www", false));
    }

    /**
     * @test
     */
    public function trimRight() {
        $str = "mmm.abc.abc";
        $this->assertEquals("mmm", StringUtil::trimRight($str, ".abc"));
    }

    /**
     * @test
     */
    public function fillZero() {
        $this->assertEquals("0001", StringUtil::fillZero(1, 4));
        $this->assertEquals("10000", StringUtil::fillZero(10000, 4));
        $this->assertEquals("01", StringUtil::fillZero(1));
        $this->assertEquals("0012", StringUtil::fillZero(12, 4));
        $this->assertEquals("12", StringUtil::fillZero(12, 2));
    }

    /**
     * @test
     */
    public function numToChinese() {
        $this->assertEquals("一万", StringUtil::numToChinese(10000));
        $this->assertEquals("壹萬", StringUtil::numToChinese(10000, true));
        $this->assertEquals("一万五千六百二十三", StringUtil::numToChinese(15623));
        $this->assertEquals("一", StringUtil::numToChinese(1));
    }
}
