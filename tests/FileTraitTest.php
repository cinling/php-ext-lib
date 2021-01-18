<?php

use cin\extLib\traits\FileTrait;
use cin\extLib\utils\FileUtil;
use PHPUnit\Framework\TestCase;


/**
 * Class FileTraitTest
 */
class FileTraitTest extends TestCase {

    /**
     * @test
     */
    public function getFileSuffix() {
        $this->assertEquals("ad", FileTrait::getFileSuffix("www.abc.ad"));
        $this->assertEquals("pdf", FileTrait::getFileSuffix("123123123sxdfa.pdf"));
        $this->assertEquals("jpg", FileTrait::getFileSuffix("9202212938.jpg"));
        $this->assertEquals("", FileTrait::getFileSuffix("9202212938"));
    }

    /**
     * @test
     */
    public function getHash8Name() {
        for ($i = 0; $i < 100; $i++) {
            $this->assertTrue(FileTrait::getHash8Name("my.psd") != FileTrait::getHash8Name("222.cc"));
            $this->assertTrue(FileTrait::getHash8Name("123.pdf") != FileTrait::getHash8Name("123.pdf"));
        }
        $this->assertTrue(strlen(FileTrait::getHash8Name("mysldjfk")) === 8);
        $this->assertTrue(strlen(FileTrait::getHash8Name("akjksdf.data")) === 13);
    }
}