<?php


use cin\extLib\vos\api\BaseRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseRequestTest
 */
class BaseRequestTest extends TestCase {

    /**
     * @test
     */
    public function setExtParams() {
        $request = new SubBaseRequest();
        $extParams = ["a" => 1, "b" => 2];
        $request->setExtParams($extParams);
        $this->assertEquals($extParams, $request->toArray());

        $request->a = 100; // extParams 优先级更高
        $this->assertEquals(["a" => 1, "b" => 2], $request->toArray());
    }
}

class SubBaseRequest extends BaseRequest {
    public $a;
}