<?php


namespace cin\extLib\enums;


/**
 * Class LogLevelEnum
 * @package cin\extLib\enums
 */
class LogLevelEnum extends BaseEnum {
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
     * @label info
     */
    const Info = "INFO ";
    /**
     * @label warn
     */
    const Warn = "WARN ";
    /**
     * @label error
     * @note Non fatal error
     */
    const Error = "ERROR";
    /**
     * @label fatal
     * @note Fatal error
     */
    const Fatal = "FATAL";

    /**
     * @return array
     */
    public static function sort() {
        return [
            LogLevelEnum::Debug,
            LogLevelEnum::Trace,
            LogLevelEnum::Info,
            LogLevelEnum::Warn,
            LogLevelEnum::Error,
            LogLevelEnum::Fatal
        ];
    }
}
