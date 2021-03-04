<?php


namespace cin\extLib\traits;


use cin\extLib\utils\JsonUtil;

/**
 * Trait StringTrait 字符串工具插件
 * @package cin\extLib\traits
 */
trait StringTrait {

    /**
     * 字符串是否以某串开始
     * @param string $origin 原字符串
     * @param string $start 字符串开头的部分
     * @return bool
     */
    public static function startWith($origin, $start) {
        return strpos($origin, $start) === 0;

    }

    /**
     * 字符串是否以某串结束
     * @param string $origin 原字符串
     * @param $end $start 字符串结尾的部分
     * @return bool
     */
    public static function endWith($origin, $end) {
        $originLen = mb_strlen($origin);
        $endLen = mb_strlen($end);
        return substr($origin, $originLen - $endLen) === $end;
    }

    /**
     * @deprecated 命名错误。将在 v3.0.0 后移除
     * @see StringTrait::endWith() 替代方法
     *
     * @param string $origin 原字符串
     * @param string $start 字符串开头的部分
     * @return bool
     */
    public static function startWidth($origin, $start) {
        return static::startWith($origin, $start);
    }

    /**
     * @deprecated 命名错误。将在 v3.0.0 后移除
     * @param string $origin 原字符串
     * @param $end $start 字符串结尾的部分
     * @return bool
     */
    public static function endWidth($origin, $end) {
        return static::endWith($origin, $end);
    }

    /**
     * 将下划线转为驼峰
     * @param string $underline 下划线变量。如：user_type
     * @param bool $isFirstBig 首字母是否大写
     * @return string 驼峰命名。如：userType
     */
    public static function underlineToHump($underline, $isFirstBig = false) {
        $hump = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $underline);
        if ($isFirstBig) {
            $hump[0] = strtoupper($hump[0]);
        }
        return $hump;
    }

    /**
     * 将驼峰转为下划线
     * @param string $hump
     * @return string 下划线命名
     */
    public static function humpToUnderline($hump) {
        $underline = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $hump);
        return ltrim($underline, "_");
    }

    /**
     * 判断字符串是否是 base64 编码
     * @param string $str
     * @return bool
     */
    public static function isBase64($str) {
        return $str == base64_encode(base64_decode($str));
    }

    /**
     * 判断字符串冲是否又某字符
     * @param string $origin 源字符串
     * @param string $search 搜索的字符串
     * @return bool
     */
    public static function has($origin, $search) {
        return strpos($origin, $search) !== false;
    }

    /**
     * 获取随机字符串
     * @param $length
     * @param string $charts
     * @return string
     */
    public static function randStr($length, $charts = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ") {
        $chartsMaxIndex = strlen($charts) - 1;
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= $charts[rand(0, $chartsMaxIndex)];    //生成php随机数
        }
        return $str;
    }

    /**
     * 去除左侧的字符
     * @param string $string
     * @param string $trim
     * @param bool $recursive
     * @return string
     */
    public static function trimLeft($string, $trim = " ", $recursive = true) {
        if (static::startWith($string, $trim)) {
            $string = mb_substr($string, mb_strlen($trim));
            if ($recursive) {
                $string = static::trimLeft($string, $trim, $recursive);
            }
        }
        return $string;
    }

    /**
     * 去除右侧的字符
     * @param string $string
     * @param string $trim
     * @param bool $recursive
     * @return string
     */
    public static function trimRight($string, $trim = " ", $recursive = true) {
        if (static::endWith($string, $trim)) {
            $string = mb_substr($string, 0, mb_strlen($string) - mb_strlen($trim));
            if ($recursive) {
                $string = static::trimRight($string, $trim, $recursive);
            }
        }
        return $string;
    }

    /**
     * Fill 0 before number
     * @param int $num
     * @param int $digit The number of characters to output a number
     * @return string
     */
    public static function fillZero($num, $digit = 2) {
        $numStr = strval($num);
        $fillNum = $digit - strlen($numStr);
        while ($fillNum-- > 0) {
            $numStr = "0" . $numStr;
        }
        return $numStr;
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function toString($value) {
        if (is_object($value) || is_array($value)) {
            $value = JsonUtil::encode($value);
        } else if (is_bool($value)) {
            $value = $value ? "true" : "false";
        } else if (is_numeric($value)) {
            $value = $value . "";
        }
        return $value;
    }

    /**
     * Arabic numerals to Chinese
     * 阿拉伯数据转汉字写法（即汉字读写）
     * @param $originalNum
     * @param bool $isUpper 是否转为中文的大写形式
     * @return string
     */
    public static function numToChinese($originalNum, $isUpper = false)
    {
        if ($isUpper) {
            $chineseNum = [
                ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'],
                ['', '拾', '佰', '仟'],
                ['', '萬', '億', '萬億']
            ];
        } else {
            $chineseNum = [
                ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'],
                ['', '十', '百', '千'],
                ['', '万', '亿', '万亿']
            ];
        }

        $num = (string)$originalNum;
        if (is_numeric($originalNum)) {
            $originalNum = explode('.', (string)floatval($originalNum));
            $num = $originalNum[0];
            $fl = isset($originalNum[1]) ? $originalNum[1] : false;
        }

        // 长度
        $len = strlen($num);
        $chinese = [];
        $str = strrev($num);

        for ($i = 0; $i < $len; $i += 4) {
            $s = [];
            $s[0] = $str[$i];
            if (isset($str[$i + 1])) {
                $s[1] = $str[$i + 1];
            }
            if (isset($str[$i + 2])) {
                $s[2] = $str[$i + 2];
            }
            if (isset($str[$i + 3])) {
                $s[3] = $str[$i + 3];
            }

            $j = '';
            // 千位
            if (isset($s[3])) {
                $s[3] = (int)$s[3];
                if ($s[3] !== 0) {
                    $j .= $chineseNum[0][$s[3]] . $chineseNum[1][3];
                } else {
                    if ($s[2] != 0 || $s[1] != 0 || $s[0] != 0) {
                        $j .= $chineseNum[0][0];
                    }
                }
            }
            // 百位
            if (isset($s[2])) {
                $s[2] = (int)$s[2];
                if ($s[2] !== 0) {
                    $j .= $chineseNum[0][$s[2]] . $chineseNum[1][2];
                } else {
                    if ($s[3] != 0 && ($s[1] != 0 || $s[0] != 0)) {
                        $j .= $chineseNum[0][0];
                    }
                }
            }
            // 十位
            if (isset($s[1])) {
                $s[1] = (int)$s[1];
                if ($s[1] !== 0) {
                    $j .= $chineseNum[0][$s[1]] . $chineseNum[1][1];
                } else {
                    if ($s[0] != 0 && !empty($s[2])) {
                        $j .= $chineseNum[0][$s[1]];
                    }
                }
            }
            // 个位
            if ($s[0] !== '') {
                $s[0] = (int)$s[0];
                if ($s[0] !== 0) {
                    $j .= $chineseNum[0][$s[0]] . $chineseNum[1][0];
                }
            }

            $j .= $chineseNum[2][$i / 4];
            array_unshift($chinese, $j);
        }

        $chs = implode('', $chinese);

        if (!empty($fl)) {
            $chs .= '点';
            for ($i = 0, $j = strlen($fl); $i < $j; $i++) {
                $t = (int)$fl[$i];
                $chs .= $str[0][$t];
            }
        }

        return $chs;
    }
}
