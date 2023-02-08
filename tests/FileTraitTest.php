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
        FileUtil::delFile($filename1);
        $this->assertFileDoesNotExist($filename1);
        $this->assertDirectoryExists($path);

        // remove path
        FileUtil::delFile($path);
        $this->assertDirectoryDoesNotExist($path);
    }

    /**
     * @test
     */
    public function scanDir() {
        // clear and make test dir
        $path = __DIR__ . "/runtime/file-trait/scan-dir";
        if (file_exists($path)) {
            FileUtil::delFile($path);
        }
        mkdir($path, 0755, true);
        $this->assertDirectoryExists($path);

        // test1
        $aDir = $path . "/a";
        mkdir($aDir, 0755, true);
        $a1Filename = $aDir . "/a1.txt";
        file_put_contents($a1Filename, "a1");
        $this->assertEquals(["a"], FileUtil::scanDir($path));
        $this->assertEquals(["a1.txt"], FileUtil::scanDir($aDir));
    }

    /**
     * @test
     */
    public function getFileSuffix() {
        $this->assertEquals("ad", FileUtil::getFileSuffix("www.abc.ad"));
        $this->assertEquals("pdf", FileUtil::getFileSuffix("123123123sxdfa.pdf"));
        $this->assertEquals("jpg", FileUtil::getFileSuffix("9202212938.jpg"));
        $this->assertEquals("", FileUtil::getFileSuffix("9202212938"));
    }

    /**
     * @test
     */
    public function getHash8Name() {
        for ($i = 0; $i < 100; $i++) {
            $this->assertTrue(FileUtil::getHash8Name("my.psd") != FileUtil::getHash8Name("222.cc"));
            $this->assertTrue(FileUtil::getHash8Name("123.pdf") != FileUtil::getHash8Name("123.pdf"));
        }
        $this->assertTrue(strlen(FileUtil::getHash8Name("mysldjfk")) === 8);
        $this->assertTrue(strlen(FileUtil::getHash8Name("akjksdf.data")) === 13);
    }
}
