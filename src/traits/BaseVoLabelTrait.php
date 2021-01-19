<?php


namespace cin\extLib\traits;

use cin\extLib\utils\StringUtil;
use ReflectionClass;

/**
 * Trait BaseVoLabelTrait
 * @package cin\extLib\traits
 */
trait BaseVoLabelTrait {
    /**
     * @var string[]
     */
    protected static $__refLabels = [];
    /**
     * @var bool Use enable reflection label
     */
    protected $__enableRefLabels = false;

    /**
     * Return label by regular matching text
     * @param string $doc
     * @return string
     */
    protected static function getLabelByDoc($doc) {
        $matches = [];
        if (empty($doc)) {
            return "";
        }
        $label = "";
        preg_match("/@label\s+(.+)\s*/", $doc, $matches);
        if (count($matches) > 1) {
            $label = $matches[1];
        }
        if ($label === "") { // @label 匹配不到内容，则尝试匹配 @var [type]
            preg_match("/@var\s+[\w|_\[\]]+\s+(.+)\s*/", $doc, $matches);
            if (count($matches) > 1) {
                $label = $matches[1];
            }
        }

        return trim($label);
    }

    /**
     * enable reflection label
     */
    protected function enableRefLabels() {
        $this->__enableRefLabels = true;
    }

    /**
     * @return string[]
     */
    protected function refLabels() {
        if (count(static::$__refLabels) > 0) {
            return static::$__refLabels;
        }
        $rClass = new ReflectionClass(static::class);
        $rProps = $rClass->getProperties();
        foreach ($rProps as $rProp) {
            $name = $rProp->getName();
            if (StringUtil::startWith($name, "__")) {
                continue;
            }
            $doc = $rProp->getDocComment();
            $label = static::getLabelByDoc($doc);
            if ($label === "") {
                $label = $name;
            }
            static::$__refLabels[$name] = $label;
        }
        return static::$__refLabels;
    }

    /**
     * @return string[]
     */
    public function labels() {
        $labels = [];
        if ($this->__enableRefLabels) {
            $labels = static::refLabels();
        }
        return $labels;
    }

    /**
     * @param string $prop
     * @return string
     */
    public function label($prop) {
        $labels = $this->labels();
        return isset($labels[$prop]) ? $labels[$prop] : $prop;
    }
}