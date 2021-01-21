<?php


namespace cin\extLib\vos\corn;


use cin\extLib\enums\ActiveEnum;
use cin\extLib\enums\TaskStateEnum;
use cin\extLib\vos\BaseVo;

/**
 * Class TaskVo 任务列表
 * @package cin\extLib\vos\corn
 */
class TaskVo extends BaseVo {
    /**
     * 任务状态：运行中
     * @deprecated Remove on 3.0.0 . Instead by TaskStateEnum
     */
    const StateRunning = 1;
    /**
     * 运行状态：运行结束
     * @deprecated Remove on 3.0.0 . Instead by TaskStateEnum
     */
    const StateEnd = 2;

    /**
     * 激活状态：激活
     * 每次运行时，都会判断是否需要执行
     * @deprecated Remove on 3.0.0 . Instead by ActiveEnum
     */
    const ActiveOn = 1;
    /**
     * 激活状态：关闭
     * 运行时不判断是否可执行。相当于被暂停
     * @deprecated Remove on 3.0.0 . Instead by ActiveEnum
     */
    const ActiveOff = 2;

    /**
     * @var int 任务id
     */
    public $id;
    /**
     * @var string 任务名字（唯一名字）
     */
    public $name;
    /**
     * @var string 任务命令
     */
    public $command;
    /**
     * @var string 运行时间配置。 crontab 格式。 如： "* * * * *"
     */
    public $cronTime;
    /**
     * @var int task state
     * @see TaskStateEnum
     */
    public $state;
    /**
     * @var int 上次运行时间。单位：时间戳（秒）
     */
    public $lastRunAt;
    /**
     * @var int 下次运行时间。单位：时间戳（秒）
     */
    public $nextRunAt;
    /**
     * @var int
     * @see ActiveEnum
     */
    public $active;
    /**
     * @var int 创建时间戳
     */
    public $createAt;
    /**
     * @var int 更新时间戳
     */
    public $updateAt;

    /**
     * 初始化一个基础数据
     * @param string $name 任务名字
     * @param string $command 任务执行的命令
     * @param string $cronTime 任务执行时间配置。 crontab 格式
     * @return TaskVo
     */
    public static function initBase($name, $command, $cronTime) {
        $vo = new TaskVo();
        $vo->name = $name;
        $vo->command = $command;
        $vo->cronTime = $cronTime;
        return $vo;
    }

    /**
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        parent::setAttrs($attrs);
        $this->id = intval($this->id);
        $this->state = intval($this->state);
        $this->lastRunAt = intval($this->lastRunAt);
        $this->nextRunAt = intval($this->nextRunAt);
        $this->active = intval($this->active);
        $this->createAt = intval($this->createAt);
        $this->updateAt = intval($this->updateAt);
     }

    /**
     * 是否运行中
     * @return bool
     */
    public function isRunning() {
        return $this->state === TaskStateEnum::Running;
    }
}