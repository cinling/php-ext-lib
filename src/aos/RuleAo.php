<?php


namespace cin\extLib\aos;

use Closure;

/**
 * Class RuleAo 规则对象
 * @package cin\extLib\aos
 */
class RuleAo extends BaseAo {
    /**
     * @var string[]
     */
    public $props;
    /**
     * @var Closure[]
     */
    public $handles;

    /**
     * @param string[] $props 需要验证的字段
     * @param Closure[] $handles 验证方法。可以通过 验证工厂服务 获取
     * @return RuleAo
     * @see ValidFactoryService 验证工厂服务。可以通过这个工厂获取验证方法
     */
    public static function initBase(array $props, array $handles) {
        $vo = new RuleAo();
        $vo->props = $props;
        $vo->handles = $handles;
        return $vo;
    }
}