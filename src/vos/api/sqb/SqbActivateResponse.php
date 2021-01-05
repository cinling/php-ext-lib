<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbActiveResponse
 * @package cin\extLib\vos\api\sqb
 */
class SqbActivateResponse extends BaseSqbResponse {

    /**
     * @var SqbCheckinBiz
     */
    public $biz_response;

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->biz_response = is_array($this->biz_response) ? SqbActivateBiz::init($this->biz_response) : new SqbActivateBiz();
    }
}