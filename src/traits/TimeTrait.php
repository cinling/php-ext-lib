<?php


namespace cin\extLib\traits;


use Closure;

/**
 * Trait TimeTrait 时间工具插件。本插件所有方法都是基于时间戳进行操作。 $stamp 兼容日期格式。如果是日期，将自动转为时间戳
 * @package cin\extLib\traits
 */
trait TimeTrait {

    /**
     * 处理时间戳输入参数。如果是 null 则转为当前时间，如果不是数字，则尝试使用 strtotime() 方法转换为时间戳
     * @param int|null $stamp
     * @return int
     */
    protected static function parseStamp($stamp) {
        if ($stamp === null) {
            $stamp = time();
        } else if (!is_numeric($stamp)) {
            $stamp = strtotime($stamp);
        }
        return $stamp;
    }

    /**
     * @deprecated 在 3.0.0 后删除。该方法没有太多的意义
     * 判断时间是不是时间戳。仅支持 秒 和 毫秒 的时间戳类型。
     * @param $time
     * @return bool
     */
    public static function isStamp($time) {
        return is_numeric($time);
    }

    /**
     * 获取当亲时间戳。单位：秒
     * @return int
     */
    public static function stamp() {
        return time();
    }

    /**
     * 当前系统时间戳（毫秒）
     * @return float 由于数字大小溢出 int 返回，因此只能转为 float
     */
    public static function stampMS() {
        $tmpArr = explode(" ", microtime());
        $secondPart = floatval($tmpArr[0]);
        $msPart = floatval($tmpArr[1]);
        return floor(($secondPart + $msPart) * 1000);
    }

    /**
     * 时间戳转日期
     * @deprecated 已更名。在 3.0.0 后删除
     * @see TimeTrait::toDate()
     * @param int $stamp
     * @return string
     */
    public static function stampToDate($stamp) {
        return self::date("Y-m-d", $stamp);
    }

    /**
     * @deprecated 已更名。在 3.0.0 后删除
     * @see TimeTrait::toDatetime()
     * @param int $stamp 时间戳转日期时间
     * @return string
     */
    public static function stampToDatetime($stamp) {
        return self::datetime("Y-m-d H:i:s", $stamp);
    }

    /**
     * 获取多少天后的时间戳
     * @deprecated 在 3.0.0 后删除
     * @see TimeTrait::nextDay() 替代方法
     * @param int $stamp 时间戳
     * @param int $days 多少天后
     * @param bool $roundToDateStart 是否将时间转为今天的0点
     * @return int
     */
    public static function nextDateStamp($stamp, $days = 1, $roundToDateStart = false) {
        $stamp += 86400 * $days;
        return $roundToDateStart ? self::getDateStart($stamp) : $stamp;
    }

    /**
     *
     * 获取多少天后的时间戳
     * @deprecated 在 3.0.0 后删除
     * @see TimeTrait::prevDay() 替代方法
     * @param int $stamp 时间戳
     * @param int $days 多少天后
     * @param bool $roundToDateStart 是否将时间转为今天的0点
     * @return int
     */
    public static function prevDateStamp($stamp, $days = 1, $roundToDateStart = false) {
        $stamp -= 86400 * $days;
        return $roundToDateStart ? self::getDateStart($stamp) : $stamp;
    }

    /**
     * 获取下一周的时间戳
     * @deprecated 在 3.0.0 后删除
     * @see TimeTrait::nextWeek() 替代方法
     * @param $stamp
     * @param int $weeks
     * @return int
     */
    public static function nextWeekStamp($stamp, $weeks = 1) {
        return $stamp + 604800 * $weeks;
    }

    /**
     * 获取上一周的时间戳
     * @deprecated 在 3.0.0 后删除
     * @see TimeTrait::prevWeek() 替代方法
     * @param $stamp
     * @param int $weeks
     * @return int
     */
    public static function prevWeekStamp($stamp, $weeks = 1) {
        return $stamp - 604800 * $weeks;
    }

    /**
     * 获取下一天的时间
     * @param int|null $stamp
     * @param int $days
     * @return int
     */
    public static function nextDay($stamp = null, $days = 1) {
        $stamp = static::parseStamp($stamp);
        return $stamp + 86400 * $days;
    }

    /**
     * 获取上一天的时间
     * @param int|null $stamp
     * @param int $days
     * @return int
     */
    public static function prevDay($stamp = null, $days = 1) {
        return static::nextDay($stamp, -$days);
    }

    /**
     * 获取下一周的时间戳
     * @param int|null $stamp
     * @param int $weeks
     * @return int
     */
    public static function nextWeek($stamp = null, $weeks = 1) {
        return $stamp + 604800 * $weeks;
    }

    /**
     * 获取上一周的时间戳
     * @param int|null $stamp
     * @param int $weeks
     * @return int
     */
    public static function prevWeek($stamp = null, $weeks = 1) {
        return static::nextWeek($stamp, -$weeks);
    }

    /**
     * 时间戳转日期
     * @param int $stamp
     * @return string
     */
    public static function toDate($stamp = null) {
        $stamp = static::parseStamp($stamp);
        return date("Y-m-d", $stamp);
    }

    /**
     * 时间戳转日期时间
     * @param int $stamp
     * @return string
     */
    public static function toDatetime($stamp = null) {
        $stamp = static::parseStamp($stamp);
        return date("Y-m-d H:i:s", $stamp);
    }

    /**
     * 获取今日起始时间戳
     * @param int $stamp
     * @return int
     */
    public static function getDateStart($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $date = self::toDate($stamp);
        return strtotime($date);
    }

    /**
     * 获取今日结束时间戳
     * @param $stamp
     * @return int
     */
    public static function getDateEnd($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $stamp = self::nextDay($stamp, 1);
        $stamp = static::getDateStart($stamp);
        return $stamp - 1;
    }

    /**
     * 获取本周一的零点时间戳
     *  一周开始定义为周一
     *  一周结束定义为周日
     * @param int|null $stamp 本周任意一个时间戳。
     * @return false|int
     */
    public static function getMonday($stamp = null) {
        $stamp = static::parseStamp($stamp);
        return strtotime(date('Y-m-d', ($stamp - ((date('w', $stamp) == 0 ? 7 : date('w', $stamp)) - 1) * 86400)));
    }

    /**
     * 获取本周二的零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getTuesday($stamp = null) {
        $mondayStamp = static::getMonday($stamp);
        return static::nextDay($mondayStamp, 1);
    }

    /**
     * 获取本周三的零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getWednesday($stamp = null) {
        $mondayStamp = static::getMonday($stamp);
        return static::nextDay($mondayStamp, 2);
    }

    /**
     * 获取本周四的零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getThursday($stamp = null) {
        $mondayStamp = static::getMonday($stamp);
        return static::nextDay($mondayStamp, 3);
    }

    /**
     * 获取本周五的零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getFriday($stamp = null) {
        $mondayStamp = static::getMonday($stamp);
        return static::nextDay($mondayStamp, 4);
    }

    /**
     * 获取本周六的零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getSaturday($stamp = null) {
        $mondayStamp = static::getMonday($stamp);
        return static::nextDay($mondayStamp, 5);
    }

    /**
     * 获取本周日的零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getSunday($stamp = null) {
        $mondayStamp = static::getMonday($stamp);
        return static::nextDay($mondayStamp, 6);
    }

    /**
     * 获取上一个月的时间戳
     * @param null $stamp
     * @return int
     */
    public static function prevMonth($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $prevStamp = strtotime('-1 month', $stamp);
        if (date("m", $stamp) === date("m", $prevStamp)) { // 还是同一个月份。说明上一个月没有这一天，使用这个月最后一天。 如：3月 的 上一个月 2月 没有 30 31 号
            $His = date("H:i:s", $stamp);
            $prevStamp = static::prevMonth($prevStamp); // 获取上一个月的时间戳
            $prevEndAt = static::getMonthEnd($prevStamp); // 获取这个月结束的时间戳
            $datetime = date("Y-m-d " . $His, $prevEndAt); // 获取这个月最后一天，并补上时间戳
            $prevStamp = strtotime($datetime); // 将日期转回时间戳
        }
        return $prevStamp;
    }

    /**
     * 获取下一个月的时间戳
     * @param null $stamp
     * @return int
     */
    public static function nextMonth($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $nextStamp = strtotime('+1 month', $stamp);
        $nextStartAt = static::getMonthEnd($stamp) + 1;
        if (date("m", $nextStartAt) !== date("m", $nextStamp)) { // 不是同一个月，说明下一个月没有这一天。如 1月 的下一个月 2月 没有 30 31 号
            $His = date("H:i:s", $stamp); // 保存时分秒
            $nextEndAt = static::getMonthEnd($nextStartAt); // 下一个月最后的时间戳
            $datetime = date("Y-m-d " . $His, $nextEndAt); // 下个月最后一天和时间的组合
            $nextStamp = strtotime($datetime);
        }
        return $nextStamp;
    }

    /**
     * 获取本月1日零点时间戳
     * @param int|null $stamp
     * @return int
     */
    public static function getMonthStart($stamp = null) {
        $stamp = static::parseStamp($stamp);
        return strtotime(date("Y-m-01", $stamp));
    }

    /**
     * @param null $stamp
     * @return false|int
     */
    public static function getMonthEnd($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $monthStartAt = static::getMonthStart($stamp);
        $nextMonthStartAt = strtotime("+1 month", $monthStartAt);
        return $nextMonthStartAt - 1;
    }

    /**
     * 计算方法的运行时间
     * @param Closure $func
     * @return int 运行用时。单位：ms
     */
    public static function countUseMS(Closure $func) {
        $startMS = self::stampMS();
        $func();
        $endMS = self::stampMS();
        return $endMS - $startMS;
    }

    /**
     * 获取日期
     * @deprecated 多余的方法 在 3.0.0 后删除
     * @param string $format
     * @param int|null $stamp
     * @return string 今天的日期
     */
    public static function date($format = "Y-m-d", $stamp = null) {$stamp = static::parseStamp($stamp);
        return date($format, $stamp);
    }

    /**
     * 获取今天的日期
     * @deprecated 多余的方法 在 3.0.0 后删除
     * @return string
     */
    public static function todayDate() {
        return self::date();
    }

    /**
     * 获取昨天的日期
     * @deprecated 多余的方法 在 3.0.0 后删除
     */
    public static function yesterdayDate() {
        $stamp = self::stamp() - 86400;
        return self::stampToDate($stamp);
    }

    /**
     * 获取现在的日期时间
     * @deprecated 多余的方法 在 3.0.0 后删除
     * @param string $format
     * @param int $stamp
     * @return string 当前日期时间
     */
    public static function datetime($format = "Y-m-d", $stamp = null) {$stamp = static::parseStamp($stamp);
        return date($format, $stamp);
    }

    /**
     * 将 日期-时间 转为时间戳
     * @deprecated 多余的方法 在 3.0.0 后删除
     * @param $datetime
     * @return int
     */
    public static function datetimeToStamp($datetime) {
        return strtotime($datetime);
    }

    /**
     * 时间取整分钟
     * @deprecated 多余的方法（可以用 date() 方法简单实现） 在 3.0.0 后删除
     * @param string $datetime
     * @return false|string
     */
    public static function floorMinute($datetime) {
        return date("Y-m-d H:i:s", strtotime($datetime));
    }
}