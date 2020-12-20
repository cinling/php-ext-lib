<?php
require_once "../../vendor/autoload.php";

use cin\extLib\services\CronService;
use cin\extLib\utils\ConsoleUtil;
use cin\extLib\utils\TimeUtil;
use cin\extLib\vos\corn\CronConfigVo;
use cin\extLib\vos\corn\TaskVo;

date_default_timezone_set('Asia/Shanghai');

/**
 * @return CronConfigVo
 */
function getConfigVo() {
    $vo = new CronConfigVo();
    $vo->taskVoList = [
        TaskVo::initBase("任务1", "php task1.php", "* * * * *"),
        TaskVo::initBase("任务2", "php task2.php", "*/10 * * * *"),
        TaskVo::initBase("任务3", "php task3.php", "10 * * * *"),
    ];
    return $vo;
}

/**
 * 初始化。一般更新项目时运行一次
 */
function init() {
    $cronSrv = CronService::getIns();
    $cronSrv->setConfigVo(getConfigVo());
    $cronSrv->init();
}

/**
 * 运行。一般每分钟运行一次
 */
function run() {
    $cronSrv = CronService::getIns();
    $cronSrv->setConfigVo(getConfigVo());
    $cronSrv->run();
}

$useMS = TimeUtil::countUseMS(function () {
//    init();
    run();
});
ConsoleUtil::output("用时：" . $useMS . "ms");