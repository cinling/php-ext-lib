<?php


use cin\extLib\exceptions\EnumException;
use cin\extLib\interfaces\Enum;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase {

    /**
     * @test
     * @throws EnumException
     */
    public function labels() {
        $this->assertEquals([1 => "A=>1", 2  => "abc eee"], AEnum::labels());
    }

    /**
     * @test
     * @throws EnumException
     */
    public function sort() {
//        $this->assertTrue([1 => "A=>1", 2  => "abc eee"] === AEnum::labels(false));
//        $this->assertTrue([2  => "abc eee", 1 => "A=>1"] === AEnum::labels(true));
//        $this->assertTrue([2  => "abc eee", 1 => "A=>1"] === AEnum::labels());

        print_r(AEnum::labels());
    }
}

class AEnum extends Enum {
    /**
     * @label A=>1
     */
    const A = 1;
    /**
     * @label abc eee
     */
    const MM = 2;

    public static function sort() {
        return [
            AEnum::MM, AEnum::A,
        ];
    }
}
