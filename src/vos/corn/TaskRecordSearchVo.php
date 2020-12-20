<?php


namespace cin\extLib\vos\corn;


use cin\extLib\vos\BaseVo;

/**
 * Class TaskRecordSearchVo 运行记录搜索了表
 * @package cin\extLib\vos\corn
 */
class TaskRecordSearchVo extends BaseVo {
    /**
     * @var int 开始时间戳（必选）
     */
    public $startTime;
    /**
     * @var int 结束时间戳（必选）
     */
    public $endTime;
    /**
     * 任务id
     * @var int[]
     */
    public $taskIds = [];
}