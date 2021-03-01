<?php


use cin\extLib\traits\ArrayTrait;
use cin\extLib\vos\BaseVo;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayTraitTest 数组工具测试
 */
class ArrayTraitTest extends TestCase {

    /**
     * @test
     * @see ArrayTrait::toArray()
     */
    public function toArray() {
        // 简单对象转数组
        $obj = (object)[];
        $obj->a = 1;
        $obj->b = 2;
        $this->assertEquals(["a" => 1, "b" => 2], ArrayTrait::toArray($obj));

        // BaseVo派生类 转数组
        $teacher = new TeacherVo();
        $teacher->name = "小明";
        $teacher->lesson = "数学";
        $this->assertEquals(["name" => "小明", "lesson" => "数学"], ArrayTrait::toArray($teacher));

        // 数组对象转数组
        $student1 = new StudentVo();
        $student1->name = "小明";
        $student1->level = "一年级";
        $student2 = new StudentVo();
        $student2->name = "小红";
        $student2->level = "二年级";
        $studentList = [$student1, $student2];
        $this->assertEquals([
            ["name" => "小明", "level" => "一年级"],
            ["name" => "小红", "level" => "二年级"],
        ], ArrayTrait::toArray($studentList));


        // 混合类型转数组
        $class = new ClassVo();
        $class->name = "一(1)班";
        $class->teacher = $teacher;
        $class->studentList = $studentList;
        $this->assertEquals([
            "name" => "一(1)班",
            "teacher" => ["name" => "小明", "lesson" => "数学"],
            "studentList" => [
                ["name" => "小明", "level" => "一年级"],
                ["name" => "小红", "level" => "二年级"],
            ],
        ], ArrayTrait::toArray($class));
    }

    /**
     * @test
     * @see ArrayTrait::filterByKeys()
     */
    public function filterByKeys() {
        $arr = ["a" => 1, "b" => 2, "c" => 3];
        $this->assertEquals(["b" => 2, "c" => 3], ArrayTrait::filterByKeys($arr, ["b", "c"]));
    }

    /**
     * @test
     * @see \cin\extLib\traits\ArrayTrait::unique();
     */
    public function unique() {
        // 常规去除
        $arr = ["a", "a", "b", "c", "c"];
        $this->assertEquals(["a", "b", "c"], ArrayTrait::unique($arr));

        // 重新排序去重（去除映射关系）
        $arr = ["a1" => 1, "a2" => 1, "b1" => 2, "c1" => 3, "c2" => 3];
        $this->assertEquals([1, 2, 3], ArrayTrait::unique($arr, true));

        // 保持映射关系去重
        $expArr = ["a1" => 1, "b1" =>2, "c1" => 3]; // 期望的值
        $resArr = ArrayTrait::unique($arr, false); // 结果值
        $this->assertEquals($expArr, $resArr);// 对比键值映射关系（无须）
        $this->assertEquals(array_keys($expArr), array_keys($resArr)); // 确认key的排序是否一致
    }

    /**
     * @test
     */
    public function in() {
        $this->assertTrue(ArrayTrait::in(["a", "b", "c"], "a"));
    }

    /**
     * @test
     */
    public function sort() {
        $arr1 = ["a" => "1", "c" => "3", "b" => 2];
        // TODO
    }
}

/**
 * Class PersonVo 人
 */
class PersonVo extends BaseVo {
    /**
     * @var string 名字
     */
    public $name;
}

/**
 * Class StudentVo 学生
 */
class StudentVo extends PersonVo {
    /**
     * @var string 年级
     */
    public $level;
}

/**
 * Class TeacherVo 老师
 */
class TeacherVo extends PersonVo {
    /**
     * @var string 教授课程
     */
    public $lesson;
}

/**
 * Class ClassVo 班级
 */
class ClassVo extends BaseVo {
    /**
     * @var string 班级名字
     */
    public $name;
    /**
     * @var TeacherVo 班主任
     */
    public $teacher;
    /**
     * @var StudentVo[] 学生列表
     */
    public $studentList;
}
