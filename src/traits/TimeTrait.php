<?php


namespace cin\extLib\traits;


use Closure;

/**
 * Trait TimeTrait Time tool plug-in. All methods of this plug-in are based on timestamp. $stamp is compatible with date format. If it is a date, it will be automatically converted to a timestamp
 * @package cin\extLib\traits
 * @see \TimeTraitTest
 */
trait TimeTrait {

    /**
     * 处理时间戳输入参数。如果是 null 则转为当前时间，如果不是数字，则尝试使用 strtotime() 方法转换为时间戳
     * @param int|string|null $stamp
     * @return int
     */
    public static function parseStamp($stamp) {
        if ($stamp === null) {
            $stamp = time();
        } else if (!is_numeric($stamp)) {
            $stamp = strtotime($stamp);
        }
        return $stamp;
    }

    /**
     * @param $time
     * @return bool
     * @deprecated 在 3.0.0 后删除。该方法没有太多的意义
     * 判断时间是不是时间戳。仅支持 秒 和 毫秒 的时间戳类型。
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
     * @param int $stamp
     * @return string
     * @deprecated 已更名。在 3.0.0 后删除
     * @see TimeTrait::toDate()
     */
    public static function stampToDate($stamp) {
        return self::date("Y-m-d", $stamp);
    }

    /**
     * @param int $stamp 时间戳转日期时间
     * @return string
     * @deprecated 已更名。在 3.0.0 后删除
     * @see TimeTrait::toDatetime()
     */
    public static function stampToDatetime($stamp) {
        return self::datetime("Y-m-d H:i:s", $stamp);
    }

    /**
     * 获取多少天后的时间戳
     * @param int $stamp 时间戳
     * @param int $days 多少天后
     * @param bool $roundToDateStart 是否将时间转为今天的0点
     * @return int
     * @deprecated 在 3.0.0 后删除
     * @see TimeTrait::nextDay() 替代方法
     */
    public static function nextDateStamp($stamp, $days = 1, $roundToDateStart = false) {
        $stamp += 86400 * $days;
        return $roundToDateStart ? self::getDateStart($stamp) : $stamp;
    }

    /**
     *
     * 获取多少天后的时间戳
     * @param int $stamp 时间戳
     * @param int $days 多少天后
     * @param bool $roundToDateStart 是否将时间转为今天的0点
     * @return int
     * @deprecated 在 3.0.0 后删除
     * @see TimeTrait::prevDay() 替代方法
     */
    public static function prevDateStamp($stamp, $days = 1, $roundToDateStart = false) {
        $stamp -= 86400 * $days;
        return $roundToDateStart ? self::getDateStart($stamp) : $stamp;
    }

    /**
     * 获取下一周的时间戳
     * @param $stamp
     * @param int $weeks
     * @return int
     * @see TimeTrait::nextWeek() 替代方法
     * @deprecated 在 3.0.0 后删除
     */
    public static function nextWeekStamp($stamp, $weeks = 1) {
        return $stamp + 604800 * $weeks;
    }

    /**
     * 获取上一周的时间戳
     * @param $stamp
     * @param int $weeks
     * @return int
     * @see TimeTrait::prevWeek() 替代方法
     * @deprecated 在 3.0.0 后删除
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
     * @param int|string|null $stamp
     * @return int
     */
    public static function getDateStart($stamp = null): int
    {
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
     * Get previous month
     * 获取上一个月的时间戳
     * @param null $stamp
     * @param int $months the number of previous months
     * @return int
     */
    public static function prevMonth($stamp = null, $months = 1) {
        $stamp = static::parseStamp($stamp);
        if ($months === 1) {
            $prevStamp = strtotime('-1 month', $stamp);
            if (date("m", $stamp) === date("m", $prevStamp)) { // 还是同一个月份。说明上一个月没有这一天，使用这个月最后一天。 如：3月 的 上一个月 2月 没有 30 31 号
                $His = date("H:i:s", $stamp);
                $prevStamp = static::prevMonth($prevStamp); // 获取上一个月的时间戳
                $prevEndAt = static::getMonthEnd($prevStamp); // 获取这个月结束的时间戳
                $datetime = date("Y-m-d " . $His, $prevEndAt); // 获取这个月最后一天，并补上时间戳
                $prevStamp = strtotime($datetime); // 将日期转回时间戳
            }
        } else {
            $prevStamp = static::nextMonth($stamp, -$months);
        }

        return $prevStamp;
    }

    /**
     * Get next month stamp
     * 获取下一个月的时间戳
     * @param null $stamp
     * @param int $months the number of next months
     * @return int
     */
    public static function nextMonth($stamp = null, $months = 1) {
        $stamp = static::parseStamp($stamp);
        $months = intval($months);
        if ($months === 0) {
            return $stamp;
        }
        $monthsFlag = $months > 0 ? "+" . $months : strval($months);

        $nextAt = strtotime($monthsFlag . " month", $stamp);
        if (date("d", $nextAt) !== date("d", $stamp)) {
            $His = date("H:i:s", $stamp); // 保存时分秒
            $prevAt = static::prevMonth($nextAt);
            $Ymd = date("Y-m-d", static::getMonthEnd($prevAt));
            $nextAt = strtotime($Ymd . " " . $His);
        }
        return $nextAt;
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
     * Gets the timestamp of the previous year
     * @param null $stamp
     * @param int $years
     * @return false|int
     */
    public static function prevYear($stamp = null, $years = 1) {
        $stamp = static::parseStamp($stamp);
        return static::nextYear($stamp, -$years);
    }

    /**
     * Gets the timestamp of the next year
     * @param null $stamp
     * @param int $years
     * @return false|int
     */
    public static function nextYear($stamp = null, $years = 1) {
        $stamp = static::parseStamp($stamp);
        $Y = date("Y", $stamp);
        $m = date("m", $stamp);
        $Y += $years;

        $targetStamp = strtotime(date($Y . "-m-d H:i:s", $stamp));
        $targetM = date("m", $targetStamp);
        if ($m !== $targetM) {
            $H_i_s = date("H:i:s", $targetStamp);

            if ($m < $targetM) {
                $prevMonthStamp = static::getMonthEnd(strtotime(date("Y-{$m}-d", $targetStamp)));
                $d = date("d", $prevMonthStamp);
                $targetStamp = strtotime("{$Y}-{$m}-{$d} {$H_i_s}");
            } else {
                $d = "01";
                $targetStamp = strtotime("{$Y}-{$m}-{$d} {$H_i_s}");
            }
        }

        return $targetStamp;
    }

    /**
     * Gets the timestamp of the start/begin of a year
     * @param null $stamp
     * @return false|int
     */
    public static function getYearStart($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $Y = date("Y", $stamp);
        return strtotime($Y . "-01-01");
    }

    /**
     * Gets the timestamp of the end of a year
     * @param null $stamp
     * @return false|int
     */
    public static function getYearEnd($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $nextYearStartAt = static::getYearStart(static::nextYear($stamp));
        return $nextYearStartAt - 1;
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
     * @param string $format
     * @param int|null $stamp
     * @return string 今天的日期
     * @deprecated 多余的方法 在 3.0.0 后删除
     */
    public static function date($format = "Y-m-d", $stamp = null) {
        $stamp = static::parseStamp($stamp);
        return date($format, $stamp);
    }

    /**
     * @return int Today 0:00 timestamp
     */
    public static function today() {
        return static::getDateStart();
    }

    /**
     * @return int Yesterday 0:00 timestamp
     */
    public static function yesterday() {
        return static::getDateStart(static::prevDay());
    }

    /**
     * @return int Tomorrow 0:00 timestamp
     */
    public static function tomorrow() {
        return static::getDateStart(static::nextDay());
    }

    /**
     * 获取今天的日期
     * @return string
     * @deprecated 多余的方法 在 3.0.0 后删除
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
     * @param string $format
     * @param int $stamp
     * @return string 当前日期时间
     * @deprecated 多余的方法 在 3.0.0 后删除
     */
    public static function datetime($format = "Y-m-d", $stamp = null) {
        $stamp = static::parseStamp($stamp);
        return date($format, $stamp);
    }

    /**
     * 将 日期-时间 转为时间戳
     * @param $datetime
     * @return int
     * @deprecated 多余的方法 在 3.0.0 后删除
     */
    public static function datetimeToStamp($datetime) {
        return strtotime($datetime);
    }

    /**
     * 时间取整分钟
     * @param string $datetime
     * @return false|string
     * @deprecated 多余的方法（可以用 date() 方法简单实现） 在 3.0.0 后删除
     */
    public static function floorMinute($datetime) {
        return date("Y-m-d H:i:s", strtotime($datetime));
    }

    /**
     * Gets the number of days between two dates
     * @param int|string $stamp1
     * @param int|string $stamp2
     * @return int
     */
    public static function comSpaceDays($stamp1, $stamp2) {
        $stamp1StartAt = static::getDateStart($stamp1);
        $stamp2StartAt = static::getDateStart($stamp2);
        return floor(abs($stamp1StartAt - $stamp2StartAt) / 86400);
    }

    /**
     * Get the number of weeks in this year by timestamp
     * 获取时间戳是这一年的第几周
     * @param $stamp
     * @return int
     */
    public static function getWeeks($stamp = null) {
        $stamp = static::parseStamp($stamp);
        $startAt = static::getDateStart($stamp);
        $yearStartAt = static::getYearStart($stamp);
        $sundayAt = static::getSunday($yearStartAt);

        $firstWeekDays = static::comSpaceDays($yearStartAt, $sundayAt) + 1; // days of the first week
        $days = static::comSpaceDays($yearStartAt, $startAt) + 1;
        return floor(($days + 6 - $firstWeekDays) / 7) + 1;
    }
}
