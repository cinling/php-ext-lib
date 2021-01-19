<?php


namespace cin\extLib\traits;

/**
 * Trait LabelTrait 标签插件
 * @package cin\extLib\traits
 * @deprecated Remove on  3.0.0 . Replace with BaseVoLabelTrait
 */
trait LabelTrait {

    /**
     * @return string[]
     */
    public function labels() {
        return [];
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