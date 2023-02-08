<?php


use cin\extLib\cos\LogCo;
use cin\extLib\services\LogService;
use cin\extLib\utils\FileUtil;
use PHPUnit\Framework\TestCase;

/**
 * Class LogServiceTest
 */
class LogServiceTest extends TestCase {

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        $co = new LogCo();
        $co->path = __DIR__ . "/runtime/log";
        FileUtil::delFile($co->path);
        LogService::getIns()->setCo($co);
    }

    /**
     * @test
     */
    public function test() {
        $this->assertTrue(true);
    }
}
