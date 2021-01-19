<?php


namespace cin\extLib\enums;


use cin\extLib\interfaces\Enum;

/**
 * Class LogLevelEnum
 * @package cin\extLib\enums
 */
class LogLevelEnum extends Enum {
    /**
     * @label trace
     * @note General log, generally used to record the input and output of the third-party interface
     */
    const Trace = "TRACE";
    /**
     * @label debug
     * @note For debugging
     */
    const Debug = "DEBUG";
    /**
     * @label trace
     */
    const Info = "INFO ";
    /**
     * @label trace
     */
    const Warn = "WARN ";
    /**
     * @label trace
     * @note Non fatal error
     */
    const Error = "ERROR";
    /**
     * @label trace
     * @note Fatal error
     */
    const Fatal = "FATAL";
}