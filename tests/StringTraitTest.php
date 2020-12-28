<?php


use cin\extLib\traits\StringTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class StringTrait
 */
class StringTraitTest extends TestCase {

    /**
     * @test
     */
    public function has() {
        $this->assertTrue(StringTrait::has("abcdefg", "cde"));
        $this->assertFalse(StringTrait::has("abcdefg", "aa"));
        $this->assertTrue(StringTrait::has("一二三四", "一"));
    }

    /**
     * @test
     */
    public function startWidth() {
        $str = "abc.abc.com";
        $this->assertTrue(StringTrait::startWith($str, "abc."));
    }

    /**
     * @test
     */
    public function endWidth() {
        $str = "www.abc.com";
        $this->assertTrue(StringTrait::endWith($str, ".com"));

        $str = "www.abc.abc";
        $this->assertTrue(StringTrait::endWith($str, ".abc"));
    }

    /**
     * @test
     */
    public function trimLeft() {
        $str = "/www/crm/runtime";
        $this->assertEquals("runtime", StringTrait::trimLeft($str, "/www/crm/"));

        $str = "/www/www/www/abc";
        $this->assertEquals("/abc", StringTrait::trimLeft($str, "/www"));
        $this->assertEquals("/www/www/abc", StringTrait::trimLeft($str, "/www", false));
    }

    /**
     * @test
     */
    public function trimRight() {
        $str = "mmm.abc.abc";
        $this->assertEquals("mmm", StringTrait::trimRight($str, ".abc"));
    }
}