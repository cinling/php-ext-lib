<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbActiveResponse
 * @package cin\extLib\vos\api\sqb
 */
class SqbActivateResponse extends BaseVo {

    /**
     * @var string 返回结果
     */
    public $result_code;
    /**
     * @var string 错误代码
     */
    public $error_code;
    /**
     * @var SqbBizResponse
     */
    public $biz_response;

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->biz_response = is_array($this->biz_response) ? SqbBizResponse::init($this->biz_response) : new SqbBizResponse();
    }

    public function hasError() {
        if ($this->result_code != "200") {
            $this->addError("请求失败");
        }
        return parent::hasError();
    }
}