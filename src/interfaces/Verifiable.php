<?php


namespace cin\extLib\interfaces;

use cin\extLib\aos\RuleAo;

/**
 * Class Verifiable 可验证接口
 * @package cin\extLib\interfaces
 */
interface Verifiable {
    /**
     * @return RuleAo[]
     */
    public function rules();

    /**
     * 验证是否合法
     * @return bool
     */
    public function valid();
}