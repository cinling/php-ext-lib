<?php


use cin\extLib\vos\BaseVo;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseVoLabelTrait
 */
class BaseVoLabelTraitTest extends TestCase {

    public function test() {
        $vo = new Vo();
        $this->assertEquals(["name" => "Name", "mobile" => "Phone and Mobile", "address" => "address"], $vo->labels());
    }
}

class Vo extends BaseVo {
    /**
     * @var string Name
     */
    public $name;
    /**
     * @var string Phone
     * @label Phone and Mobile
     */
    public $mobile;
    public $address;

    protected function onInit() {
        $this->enableRefLabels();
    }
}