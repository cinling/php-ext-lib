<?php


namespace cin\extLib\interfaces;

use cin\extLib\traits\ErrorTrait;
use cin\extLib\vos\RuleVo;

/**
 * Class Verifiable 可验证接口
 * @package cin\extLib\interfaces
 */
interface Verifiable {
    /**
     * @return RuleVo[]
     */
    public function rules();

    /**
     * 验证是否合法
     * @return bool
     */
    public function valid();
}