<?php


namespace cin\extLib\traits;


use cin\extLib\utils\EncryptUtil;
use cin\extLib\utils\StringUtil;
use cin\extLib\utils\TimeUtil;

trait FileTrait {
    /**
     * 删除文件夹及下面所有的问题金，或删除文件
     * @param string $dirOrFile 目录或文件
     */
    public static function delFile($dirOrFile) {
        if (!file_exists($dirOrFile)) {
            return;
        }

        if (StringUtil::endWith($dirOrFile, "/")) {
            $dirOrFile = substr($dirOrFile, 0, mb_strlen($dirOrFile) - 1);
        }

        if (is_dir($dirOrFile)) {
            $files = scandir($dirOrFile);
            foreach ($files as $file) {
                if (in_array($file, [".", ".."])) {
                    continue;
                }
                $absFilename = $dirOrFile . "/" . $file;
                static::delFile($absFilename);
            }
            rmdir($dirOrFile);
        } else {
            unlink($dirOrFile);
        }
    }

    /**
     * 扫描目录下所有的子目录和文件
     * @param string $path 扫描的路径
     * @param string[] $excludes 排除的子项
     * @return string[]
     */
    public static function scanDir($path, $excludes = [".", ".."]) {
        if (!file_exists($path)) {
            return [];
        }
        $files = scandir($path);
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if (in_array($file, $excludes)) {
                    unset($files[$key]);
                }
            }
        }
        return $files;
    }

    /**
     * 获取文件后缀名
     * @param $filename
     * @return string|string[]
     */
    public static function getFileSuffix($filename) {
        return  pathinfo($filename, PATHINFO_EXTENSION);
    }

    /**
     * 去除文件后缀名
     * @param string $filename
     * @return string
     */
    public static function excludeSuffix($filename) {
        $suffix = static::getFileSuffix($filename);
        $tmpArr = explode(".", $filename);
        if (is_array($tmpArr)) {
            $lastIndex = count($tmpArr) - 1;
            if ($tmpArr[$lastIndex] == $suffix) {
                unset($tmpArr[$lastIndex]);
                $filename = implode(".", $tmpArr);
            }
        }
        return $filename;
    }

    /**
     * Gets the 8-bit hash name of the file. Add time and random string as encrypted ciphertext when encrypting
     * @param string $filename
     * @return string
     * @example Input: "worksheet.xlsx", Output: "35cf061a.xlsx"
     */
    public static function getHash8Name($filename) {
        $suffix = static::getFileSuffix($filename);
        $hasSuffix = !empty($suffix);
        $name = static::excludeSuffix($filename);
        $sha512 = EncryptUtil::sha512($name . StringUtil::randStr(128) . TimeUtil::stampMS());
        $hashName = substr($sha512, 60, 8);
        if ($hasSuffix) {
            $hashName .= "." . $suffix;
        }
        return $hashName;
    }
}