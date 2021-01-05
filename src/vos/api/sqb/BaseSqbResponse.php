<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbResponse 收钱吧通用返回接口
 * @package cin\extLib\vos\api\sqb
 */
class BaseSqbResponse extends BaseVo {
    /**
     * @var string 返回结果
     */
    public $result_code;
    /**
     * @var string 错误代码
     */
    public $error_code;
    /**
     * @var string 错误代码
     */
    public $error_message;

    /**
     * @return bool
     */
    public function hasError() {
        if ($this->result_code != "200") {
            $this->addError($this->error_code . ":" . $this->error_message);
        }
        return parent::hasError();
    }

}