<?php


namespace cin\extLib\vos\api;


use cin\extLib\utils\ArrayUtil;
use cin\extLib\vos\BaseVo;

/**
 * Class BaseRequest 基础请求参数
 * @package cin\extLib\vos\api
 */
class BaseRequest extends BaseVo {

    /**
     * @var mixed[] 额外的请求参数。在 toArray() 时会合并到数组中
     */
    protected $__extParams = [];

    /**
     * @param mixed[] $extParams
     */
    public function setExtParams($extParams){
        $this->__extParams = $extParams;
    }

    /**
     * @return array
     */
    public function toArray() {
        $attrs = parent::toArray();
        $attrs = ArrayUtil::merge($attrs, $this->__extParams);
        return $attrs;
    }

    /**
     * 转换为get参数
     * @return string
     */
    public function toGetParams() {
        return http_build_query($this->toArray());
    }
}