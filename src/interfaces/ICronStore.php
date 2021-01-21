<?php


namespace cin\extLib\interfaces;


use cin\extLib\exceptions\CronException;
use cin\extLib\vos\corn\TaskRecordVo;
use cin\extLib\vos\corn\TaskVo;

/**
 * Interface ICronStore
 * @package cin\extLib\interfaces
 */
interface ICronStore {
    /**
     * @return TaskVo[] Get all cron tasks
     * @throws CronException
     */
    public function getTaskVoList();

    /**
     * Set all cron tasks that can be run
     * @param TaskVo[] $taskVoList
     * @throws CronException
     */
    public function setTaskVoList(array $taskVoList);

    /**
     * save cron task
     * @param TaskVo $taskVo
     * @throws CronException
     */
    public function setTaskVo(TaskVo $taskVo);

    /**
     * add task run record
     * @param TaskRecordVo $taskRecordVo 记录
     * @param int $limit 限制条数。0代表不限制
     * @throws CronException
     */
    public function addTaskRecordVo(TaskRecordVo $taskRecordVo, $limit = 0);

    /**
     * get all task record
     * @return TaskRecordVo[]
     * @throws CronException
     */
    public function getTaskRecordVoList();
}