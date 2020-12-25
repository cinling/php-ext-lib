<?php


use PHPUnit\Framework\TestCase;

/**
 * Class JustTest 即时测试
 */
class JustTest extends TestCase {


    /**
     */
    public function run1() {
        echo \cin\extLib\utils\HttpUtil::get("http://crm.local/mini/ApiConnect/getCollPromFulLVo", ["prom_id" => 1]);
    }
}