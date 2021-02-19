<?php

use cin\extLib\traits\FileTrait;
use PHPUnit\Framework\TestCase;


/**
 * Class FileTraitTest
 */
class FileTraitTest extends TestCase {

    /**
     * @test
     */
    public function delFile() {
        // make test dir
        $path = __DIR__ . "/runtime/file-trait/del-file";
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $this->assertDirectoryExists($path);

        // create file1
        $filename1 = $path . "/1.txt";
        $content1 = "111";
        file_put_contents($filename1, $content1);
        $this->assertEquals($content1, file_get_contents($filename1));

        // remove file1
        FileTrait::delFile($filename1);
        $this->assertFileNotExists($filename1);
        $this->assertDirectoryExists($path);

        // remove path
        FileTrait::delFile($path);
        $this->assertDirectoryNotExists($path);
    }

    /**
     * @test
     */
    public function scanDir() {
        // clear and make test dir
        $path = __DIR__ . "/runtime/file-trait/scan-dir";
        if (file_exists($path)) {
            FileTrait::delFile($path);
        }
        mkdir($path, 0755, true);
        $this->assertDirectoryExists($path);

        // test1
        $aDir = $path . "/a";
        mkdir($aDir, 0755, true);
        $a1Filename = $aDir . "/a1.txt";
        file_put_contents($a1Filename, "a1");
        $this->assertEquals(["a"], FileTrait::scanDir($path));
        $this->assertEquals(["a1.txt"], FileTrait::scanDir($aDir));
    }

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
