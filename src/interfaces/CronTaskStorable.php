<?php


namespace cin\extLib\interfaces;


use cin\extLib\exceptions\CronException;
use cin\extLib\vos\corn\TaskRecordVo;
use cin\extLib\vos\corn\TaskVo;

/**
 * Class CronTaskStorable 定时任务存取接口
 * @deprecated Remove on 3.0.0 . Instead by ICronStore
 * @package cin\extLib\interfaces
 */
interface CronTaskStorable extends ICronStore {
//    /**
//     * @return TaskVo[] 获取所有定时任务
//     * @throws CronException
//     */
//    public function getTaskVoList();
//
//    /**
//     * 设置所有可运行的定时任务
//     * @param TaskVo[] $taskVoList
//     * @throws CronException
//     */
//    public function setTaskVoList(array $taskVoList);
//
//    /**
//     * 保存单个 TaskVo 数据
//     * @param TaskVo $taskVo
//     * @throws CronException
//     */
//    public function setTaskVo(TaskVo $taskVo);
//
//    /**
//     * 添加任务运行记录
//     * @param TaskRecordVo $taskRecordVo 记录
//     * @param int $limit 限制条数。0代表不限制
//     * @throws CronException
//     */
//    public function addTaskRecordVo(TaskRecordVo $taskRecordVo, $limit = 0);
//
//    /**
//     * @return TaskRecordVo[]
//     * @throws CronException
//     */
//    public function getTaskRecordVoList();
}