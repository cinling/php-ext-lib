<?php


use cin\extLib\interfaces\Enum;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase {

    /**
     * @test
     */
    public function labels() {
        AEnum::labels();
    }
}

class AEnum extends Enum {
    /**
     * @label A=>1;
     */
    const A = 1;
}