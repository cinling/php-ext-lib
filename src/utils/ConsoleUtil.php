<?php


namespace cin\extLib\utils;


use const STDOUT;

class ConsoleUtil {
    /**
     * Prints text to STDOUT appended with a carriage return (PHP_EOL).
     *
     * @param string $string the text to print
     * @return int|bool number of bytes printed or false on error.
     */
    public static function output($string = null)
    {
        return static::stdout($string . PHP_EOL);
    }

    /**
     * Prints a string to STDOUT.
     *
     * @param string $string the string to print
     * @return int|bool Number of bytes printed or false on error
     */
    public static function stdout($string)
    {
        return fwrite(STDOUT, $string);
    }

    public static function process() {
        $count = 100;
        for ($i = 1; $i <= 100; $i++) {
            usleep(50000);
            //str_repeat 函数的作用是重复这个符号多少次
            $equalStr = str_repeat("=", $i);
            $space    = str_repeat(" ", $count - $i);
            echo("\r [$equalStr>$space]($i/$count%)");
        }
    }
}