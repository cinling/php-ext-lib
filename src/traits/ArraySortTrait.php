<?php


namespace cin\extLib\traits;


trait ArraySortTrait {
    /**
     * 属性排序。toArray() 时用到。设置了排序的字段，会排到前面
     * @return string[]
     */
    public function sortSequence() {
        return [];
    }

    /**
     * @param $arr
     */
    public function sortArray(&$arr) {
        $tmpArr = $arr; // 记录数组的值
        $seqArrKey = $this->sortSequence();
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
}