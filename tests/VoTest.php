<?php


use cin\extLib\vos\BaseVo;
use PHPUnit\Framework\TestCase;

/**
 * Class VoTest 模型对象测试
 */
class VoTest extends TestCase {

    /**
     * @test
     */
    public function sort() {
        $vo = new SortTestVo();
        $this->assertEquals(["a" => 1, "b" => 2], $vo->toArray());
    }
}

/**
 * Class SortTestVo
 */
class SortTestVo extends BaseVo {
    public $b = 2;
    public $a = 1;

    /**
     * @return string[]
     */
    public function sortSequence() {
        return ["a", "b"];
    }
}