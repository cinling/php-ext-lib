<?php


use PHPUnit\Framework\TestCase;

/**
 * Class JustTest 即时测试
 */
class JustTest extends TestCase {

    /**
     * 临时测试代码
     */
    public function test1() {
        $c1 = new Child1();
        $c2 = new Child2();

        $c1::$val = 2;

        $this->assertEquals(2, $c2::$val);
    }

    public function test2() {
    }
}

class ParentCls {
    public static $val = 1;
}

class Child1 extends ParentCls {

}

class Child2 extends ParentCls {

}