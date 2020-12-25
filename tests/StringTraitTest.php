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
}