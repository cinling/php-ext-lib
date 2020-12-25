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
        $request = new BaseRequest();
        $extParams = ["a" => 1, "b" => 2];
        $request->setExtParams($extParams);
        $this->assertEquals($extParams, $request->toArray());
    }
}