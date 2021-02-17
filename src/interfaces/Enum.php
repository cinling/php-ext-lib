<?php


namespace cin\extLib\interfaces;


use cin\extLib\aos\ReflectConstAo;
use cin\extLib\enums\LogLevelEnum;
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
     * Add "@label label content" to constant document to mark constant label content
     * @param bool $sort
     * @return string[]
     * @throws EnumException
     */
    public static function labels($sort = true) {
        $labels = ValueUtil::getValue(self::$enumLabels, static::class, null);
        if ($labels === null) {
            $labels = static::getLabelsByRef();
        }

        if ($sort) {
            $keys = static::sort();
            $sortLabels = [];
            foreach ($keys as $key) {
                if (!isset($labels[$key])) {
                    continue;
                }
                $sortLabels[$key] = $labels[$key];
            }
            foreach ($labels as $key => $value) {
                if (!isset($sortLabels[$key])) {
                    $sortLabels[$key] = $value;
                }
            }
            $labels = $sortLabels;
            unset($sortLabels);
        }

        self::$enumLabels[static::class] = $labels;
        return $labels;
    }

    /**
     * Get all values of the constants
     * @return mixed[]
     * @throws EnumException
     */
    public static function values() {
        $labels = static::labels();
        return array_keys($labels);
    }

    /**
     * Sort the array of Enum::labels()
     *  If the field does not appear in the array, it is sorted to the end by the original order
     * @see Enum::labels() Use in this function
     * @see LogLevelEnum::sort() Example
     * @return string[]
     */
    public static function sort() {
        return [];
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
                $labels[$value] = trim($label);
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
                $labels[$value] = trim($label);
            }
        }

        return $labels;
    }

    /**
     * 通过正则匹配文档获取标签值
     * @param string $doc
     * @return string 如果没有匹配成功，则返回空字符串
     */
    protected static function getLabelByDoc($doc) {
        $matches = [];
        if (empty($doc)) {
            return "";
        }
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
        if (isset($labels[$value])) {
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
