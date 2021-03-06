<?php


namespace cin\extLib\vos;


use cin\extLib\aos\RuleAo;
use cin\extLib\services\ValidFactoryService;
use Closure;

/**
 * Class RuleVo 规则vo
 * @package cin\extLib\vos
 *
 * @deprecated 3.0.0 后删除。已重命名为 RuleAo
 * @see RuleAo
 */
class RuleVo extends BaseVo {
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
     * @return RuleVo
     * @see ValidFactoryService 验证工厂服务。可以通过这个工厂获取验证方法
     */
    public static function initBase(array $props, array $handles) {
        $vo = new RuleVo();
        $vo->props = $props;
        $vo->handles = $handles;
        return $vo;
    }
}