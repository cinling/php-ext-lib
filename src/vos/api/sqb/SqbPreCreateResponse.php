<?php


namespace cin\extLib\vos\api\sqb;


/**
 * Class SqbPreCreateResponse
 * @package cin\extLib\vos\api\sqb
 */
class SqbPreCreateResponse extends BaseSqbResponse {

    /**
     * @var SqbPreCreateBiz
     */
    public $biz_response;

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->biz_response = !empty($this->biz_response) ? SqbPreCreateBiz::init($this->biz_response) : new SqbPreCreateBiz();
    }
}