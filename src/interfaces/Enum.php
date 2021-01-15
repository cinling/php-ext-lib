<?php


namespace cin\extLib\interfaces;


use cin\extLib\aos\ReflectConstAo;
use cin\extLib\exceptions\EnumException;
use cin\extLib\utils\EnvUtil;
use cin\extLib\utils\ValueUtil;
use ReflectionClass;

/**
 * Class Enum 枚举基类
 * @package cin\extLib\interfaces
 */
abstract class Enum {
    /**
     * @var mixed[] 类名 => 标签数组: string[]
     */
    private static $enumLabels = [];

    /**
     * 在常量文档上添加 "@label 标签内容" 即可标记常量的标签内容
     * @return string[]
     * @throws EnumException
     */
    public static function labels() {
        $labels = ValueUtil::getValue(self::$enumLabels, static::class, null);
        if ($labels === null) {
            $labels = static::getLabelsByRef();
        }
        self::$enumLabels[static::class] = $labels;
        return $labels;
    }

    /**
     * 通过反射获取标签
     * @return string[]
     * @throws EnumException
     */
    protected static function getLabelsByRef() {
        $labels = [];
        if (EnvUtil::isGtePhp71()) { // php 7.1 及以上版本使用原生反射
            $rClass = new ReflectionClass(static::class);
            $rConstants = $rClass->getReflectionConstants();
            foreach ($rConstants as $rConstant) {
                $doc = $rConstant->getDocComment();
                $value = $rConstant->getValue();
                $label = static::getLabelByDoc($doc);
                $name = $rConstant->getName();
                if ($label === "") {
                    $label = $name;
                }
                static::uniqueCheck($labels, $value, $name);
                $labels[$value] = $label;
            }
        } else { // php 7.0 及 php 5.6 版本 。使用自定义的反射对象辅助反射出文档内容
            $rAo = new ReflectConstAo(static::class);
            $rClass = new ReflectionClass(static::class);
            $constants = $rClass->getConstants();
            foreach ($constants as $name => $value) {
                $doc = $rAo->getDocComment($name);
                $label = static::getLabelByDoc($doc);
                if ($label === "") {
                    $label = $name;
                }
                static::uniqueCheck($labels, $value, $name);
                $labels[$value] = $label;
            }
        }

        // 唯一性检测

        return $labels;
    }

    /**
     * 通过正则匹配文档获取标签值
     * @param string $doc
     * @return string 如果没有匹配成功，则返回空字符串
     */
    protected static function getLabelByDoc($doc) {
        $matches = [];
        preg_match("/@label\s+(.+)\s*/", $doc, $matches);
        if (count($matches) > 1) {
            return $matches[1];
        }
        return "";
    }

    /**
     * @param string[] $labels
     * @param string|int|float $value
     * @param string $name
     * @throws EnumException
     */
    protected static function uniqueCheck($labels, $value, $name) {
        if (isset($labels, $value)) {
            throw new EnumException("存在相同的值。[" . $name . ":" . $value . "]");
        }
    }

    /**
     * 获取常量的标签值
     * @param int|string $value
     * @return string
     * @throws EnumException
     */
    public static function label($value) {
        $labels = static::labels();
        return ValueUtil::getValue($labels, $value, "");
    }
}