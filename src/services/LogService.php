<?php


namespace cin\extLib\services;


use cin\extLib\cos\LogCo;
use cin\extLib\enums\LogLevelEnum;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\TimeUtil;
use cin\extLib\vos\LogConfigVo;

/**
 * Class LogService
 * @package cin\extLib\services
 */
class LogService {
    use SingleTrait;

    /**
     * @var LogCo
     */
    protected $co;

    /**
     * LogService constructor.
     */
    protected function __construct() {
        $this->setConfig(new LogConfigVo());
        $this->setCo(new LogCo());
    }

    /**
     * 设置配置
     * @param LogConfigVo $confVo
     * @deprecated Remove on 3.0.0  Replace with setCo()
     */
    public function setConfig(LogConfigVo $confVo) {
        $this->co = $confVo;
        if (!file_exists($this->co->path)) {
            mkdir($this->co->path, 0755, true);
        }
    }

    /**
     * Setting LogService configuration
     * @param LogCo $co
     */
    public function setCo(LogCo $co) {
        $this->co = $co;
        if (!file_exists($this->co->path)) {
            mkdir($this->co->path, 0755, true);
        }
    }

    /**
     * @param string $level
     * @param string $title
     * @param string $content
     */
    protected function base($level, $title, $content) {
        $filePath = $this->co->path . "/cin.log";
        if (file_exists($filePath) && filesize($filePath) > $this->co->fileMaxSize) {
            $bakFilePath = $this->co->path . "/cin_" . date("Ymd_His") . ".log";
            rename($filePath, $bakFilePath);
        }

        $writeContent = "[" . TimeUtil::toDatetime() . " " . $level . " " . $title . "] " . $content . PHP_EOL;
        file_put_contents($filePath, $writeContent, FILE_APPEND | LOCK_EX);
    }

    /**
     * @param $content
     * @param string $title
     */
    public function trace($content, $title = "cin-trace") {
        $this->base(LogLevelEnum::Trace, $title, $content);
    }

    /**
     * @param $content
     * @param string $title
     */
    public function debug($content, $title = "cin-debug") {
        $this->base(LogLevelEnum::Debug, $title, $content);
    }

    /**
     * @param $content
     * @param string $title
     */
    public function info($content, $title = "cin-info") {
        $this->base(LogLevelEnum::Info, $title, $content);
    }

    /**
     * @param $content
     * @param string $title
     */
    public function warn($content, $title = "cin-warn") {
        $this->base(LogLevelEnum::Warn, $title, $content);
    }

    /**
     * @param $content
     * @param string $title
     */
    public function error($content, $title = "cin-error") {
        $this->base(LogLevelEnum::Error, $title, $content);
    }

    /**
     * @param $content
     * @param string $title
     */
    public function fatal($content, $title = "cin-fatal") {
        $this->base(LogLevelEnum::Fatal, $title, $content);
    }
}