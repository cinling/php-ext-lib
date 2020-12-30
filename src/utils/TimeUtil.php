<?php

namespace cin\extLib\utils;


use cin\extLib\traits\TimeTrait;
use Closure;

/**
 * Class TimeUtil 时间工具
 * @package cin\extLib\utils
 *
 * 标准时间格式： 2006-01-02 15:04:05
 */
class TimeUtil {
    use TimeTrait;

    /**
     * @deprecated 在 3.0.0 后删除
     * 【时间】格式：常规（横线）
     */
    const DateFormatHorizontalLine = "Y-m-d";

    /**
     * @deprecated 在 3.0.0 后删除
     * 【时间-日期】格式：常规（横线）
     */
    const DatetimeFormatHorizontalLine = "Y-m-d H:i:s";
}