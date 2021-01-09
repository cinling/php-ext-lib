<?php


use PHPUnit\Framework\TestCase;

/**
 * Class VersionTest
 */
class VersionTest extends TestCase {

    /**
     * @test
     */
    public function tryCatch56() {
        try {
            throw new Exception("123");
        } catch (Error $e) {
            echo "成功捕捉异常";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}