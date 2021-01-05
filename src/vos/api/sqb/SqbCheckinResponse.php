<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbCheckinResponse
 * @package cin\extLib\vos\api\sqb
 */
class SqbCheckinResponse extends BaseVo {

    /**
     * @var string 返回结果
     */
    public $result_code;
    /**
     * @var SqbCheckinBiz
     */
    public $biz_response;

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->biz_response = is_array($this->biz_response) ? SqbCheckinBiz::init($this->biz_response) : new SqbCheckinBiz();
    }

    public function hasError() {
        if ($this->result_code != "200") {
            $this->addError("请求失败");
        }
        return parent::hasError();
    }
}