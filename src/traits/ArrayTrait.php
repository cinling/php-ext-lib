<?php


namespace cin\extLib\traits;


use cin\extLib\interfaces\Arrayable;

/**
 * Trait ArrayTrait 数组工具插件
 * @package cin\extLib\traits
 */
trait ArrayTrait {
    /**
     * 将数据转为 数组
     * @param mixed $attrs 需要转为数组的对象（可以是任何类型）
     * @return array
     */
    public static function toArray($attrs) {
        if (is_array($attrs)) {
            foreach ($attrs as &$value) {
                if (is_object($value) || is_array($value))  {
                    $value = static::toArray($value);
                }
            }
            return $attrs;
        } else if (is_object($attrs)) {
            if ($attrs instanceof Arrayable) {
                $attrs = $attrs->toArray();
            } else {
                $attrs = get_object_vars($attrs);
            }
            foreach ($attrs as &$value) {
                if (is_object($value) || is_array($value))  {
                    $value = static::toArray($value);
                }
            }
            return $attrs;
        }

        return [$attrs];
    }

    /**
     * 获取数组中指定的 keys 中的数据
     * @param mixed[] $arr 原数组
     * @param int[]|string[] $keys 筛选值
     * @return mixed[]
     */
    public static function filterByKeys(array $arr, array $keys) {
        $retArr = [];
        $flipKeys = array_flip($keys);
        foreach ($arr as $key => $value) {
            if (isset($flipKeys[$key])) {
                $retArr[$key] = $value;
            }
        }
        return $retArr;
    }

    /**
     * 获取数组唯一值
     * @param array $array
     * @param bool $resort
     * @return array
     */
    public static function unique(array $array, $resort = true) {
        $retArr = array_unique($array);
        if ($resort) {
            $retArr = array_values($retArr);
        }
        return $retArr;
    }

    /**
     * 是否在数组里
     * @param array $array
     * @param int|string $key
     * @return bool
     */
    public static function in(array $array, $key) {
        return in_array($key, $array);
    }

    /**
     * 根据二位数组中子项的属性值进行排序。并保留数组 key => value 映射关系
     * @param array $array
     * @param string|int $prop
     * @param int $sort
     * @return array
     */
    public static function sort(array $array, $prop, $sort = SORT_ASC) {
        $sortArray = []; // 排序专用数组
        foreach ($array as $key => $item) {
            if (is_object($item) && property_exists($item, $prop)) {
                $value = $item->$prop;
            } else if (is_array($item) && array_key_exists($prop, $item)) {
                $value = $item[$prop];
            } else {
                $value = null;
            }

            $sortArray[$key] = $value;
        }

        if ($sort === SORT_ASC) {
            asort($sortArray);
        } else if ($sort === SORT_DESC) {
            arsort($sortArray);
        }

        $retArray = [];
        foreach ($sortArray as $key => $value) {
            $retArray[$key] = $array[$key];
        }
        return $retArray;
    }

    /**
     * 获取数组中的子项
     * @param array $array 数组
     * @param int|string $key 数组key
     * @param mixed $default 默认值。如果key不存在则返回默认值
     * @return mixed|string
     */
    public static function getItem(array $array, $key, $default = "") {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * 合并数组
     * @param array $aArray
     * @param array $bArray
     * @return array
     */
    public static function merge(array $aArray, array $bArray) {
        return array_merge($aArray, $bArray);
    }

    /**
     * 切割数据组，并保留映射关系
     * @param array $array 原数组
     * @param int $offset 偏移位置
     * @param int $length 需要获取的长度。0代表不限制，获取后面所有数据
     * @return array
     */
    public static function splice(array $array, $offset, $length = 0) {
        $retArray = [];

        $keys = array_keys($array);
        $size = count($keys);
        if ($offset >= $size) {
            return $retArray;
        }

        $endIndex = !empty($length) ? $offset + $length - 1 : $size - 1;
        if ($endIndex >= $size) {
            $endIndex = $size - 1;
        }

        for ($i = $offset; $i <= $endIndex; $i++) {
            $key = $keys[$i];
            $value = $array[$key];
            $retArray[$key] = $value;
        }
        return $retArray;
    }

    /**
     * 删除数组中的元素
     * @param array $array
     * @param mixed|mixed[] $removeItem
     * @return array
     */
    public static function remove(array $array, $removeItem) {
        if (!is_array($removeItem)) {
            $removeItem = [$removeItem];
        }
        return array_diff($array, $removeItem);
    }
}