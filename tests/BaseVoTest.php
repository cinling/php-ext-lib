<?php


use cin\extLib\traits\BaseVoTrait;
use cin\extLib\vos\BaseVo;
use PHPUnit\Framework\TestCase;

/**
 * Class VoTest 模型对象测试
 */
class BaseVoTest extends TestCase {

    /**
     * @test
     */
    public function sort() {
        $vo = new SortTestVo();
        $this->assertTrue(["a" => 1, "b" => 2, "c" => 3] === $vo->toArray());
    }
}

/**
 * Class SortTestVo
 */
class SortTestVo extends BaseVo {
    public $c = 3;
    public $b = 2;
    public $a = 1;

    /**
     * @return string[]
     */
    public function sortSequence() {
        return ["a", "b"];
    }
}

class Clazz {
    use BaseVoTrait;

    public $name;

    /**
     * @var Teacher
     */
    public $teacher;

    /**
     * @var Group[]
     */
    public $groups;
}

class Group {
    use BaseVoTrait;

    public $name;

    /**
     * @var Student[]
     */
    public $students;
}

class Teacher {
    use BaseVoTrait;

    public $name;

}

class Student {
    use BaseVoTrait;

    public $name;
}