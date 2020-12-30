<?php


namespace cin\extLib\interfaces;


use cin\extLib\utils\ValueUtil;
use ReflectionClass;
use ReflectionException;

/**
 * Class Enum 枚举基类
 * @package cin\extLib\interfaces
 *
 * @deprecated 未完成 TODO
 */
abstract class Enum {
    /**
     * @var mixed[] 类名 => 标签数组: string[]
     */
    private static $enumLabels = [];

    /**
     * 在常量文档上添加 "@label 标签内容" 即可标记常量的标签内容
     * @return string[]
     * @throws ReflectionException
     */
    public static function labels() {
//        $labels = ValueUtil::getValue(self::$enumLabels, static::class, null);
//        if ($labels === null) { // 通过反射加载
//            $labels = [];
//            $rClass = new ReflectionClass(static::class);
//            $constants = ;
//            print_r($constants);
////            foreach ($constants as $prop => $value) {
////                $rConstant = $rClass->getProperty($prop);
////                $doc = $rConstant->getDocComment();
////                $label = static::getLabelByDoc($doc);
////                if ($label === "") {
////                    $label = $rConstant->getName();
////                }
////                $labels[$rConstant->getValue()] = $label;
////            }
////
////            self::$enumLabels[static::class] = $labels;
//
//        }
//        return $labels;
    }

    /**
     * 通过正则匹配文档获取标签值
     * @param string $doc
     * @return string 如果没有匹配成功，则返回空字符串
     */
    protected static function getLabelByDoc($doc) {
        $matches = [];
        preg_match("/@label\s+(.+)\s+/", $doc, $matches);
        if (count($matches) > 1) {
            return $matches[1];
        }
        return "";
    }

    /**
     * 获取常量的标签值
     * @param int|string $value
     * @return string
     * @throws ReflectionException
     */
    public static function label($value) {
        $labels = static::labels();
        return ValueUtil::getValue($labels, $value, "");
    }
}