<?php


namespace cin\extLib\traits;

/**
 * Trait PropSortTrait 属性排序
 * @package cin\extLib\traits
 */
trait PropSortTrait {
    /**
     * 属性排序。toArray() 时用到。设置了排序的字段，会排到前面
     * @deprecated 已废弃，请用 propSort() 代替
     *  如果该方法和 propSort() 同时有值。则优先实用 sortSequence() 的值
     * @removed 3.0
     * @see PropSortTrait::propSort()
     * @return string[]
     */
    public function sortSequence() {
        return [];
    }

    /**
     * 属性排序。toArray() 时用到。设置了排序的字段，会排到前面
     * @return array
     */
    public function propSort() {
        $propSort = $this->sortSequence();
        if (!empty($propSort)) {
            return $propSort;
        }
        return [];
    }

    /**
     * @deprecated 已废弃。
     * @removed 3.0
     * @param $arr
     */
    public function sortArray(&$arr) {
        $tmpArr = $arr; // 记录数组的值
        $seqArrKey = $this->propSort();
        foreach ($tmpArr as $key => $value) {
            if (in_array($key, $seqArrKey)) {
                continue;
            }
            $seqArrKey[] = $key;
        }
        $arr = [];
        foreach ($seqArrKey as $key) {
            $arr[$key] = $tmpArr[$key];
        }
    }

    /**
     * 排序数组
     * @param $array
     */
    protected function arrayPropSort(&$array) {
        $tmpArray = $array; // 记录数组的值
        $seqArrKey = $this->propSort();
        foreach ($tmpArray as $key => $value) {
            if (in_array($key, $seqArrKey)) {
                continue;
            }
            $seqArrKey[] = $key;
        }
        $array = [];
        foreach ($seqArrKey as $key) {
            $array[$key] = $tmpArray[$key];
        }
    }
}