<?php


namespace cin\extLib\vos\api\sqb;


/**
 * Class SqbPreCreateBiz
 * @package cin\extLib\vos\api\sqb
 */
class SqbPreCreateBiz extends BaseSqbResponse {
    /**
     * @var string 错误代码
     */
    public $error_code_standard;
    /**
     * @var SqbPreCreateBizData
     */
    public $data;

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->data = !empty($this->data) ? SqbPreCreateBizData::init($this->data) : new SqbPreCreateBizData();
    }
}