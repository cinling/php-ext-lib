<?php


namespace cin\extLib\vos\corn;


use cin\extLib\aos\CronFileStoreAo;
use cin\extLib\interfaces\CronTaskStorable;
use cin\extLib\vos\BaseVo;

/**
 * Class CronConfigVo 服务配置
 * @package cin\extLib\vos\corn
 */
class CronConfigVo extends BaseVo {
    /**
     * @var CronTaskStorable 存取实例
     */
    public $store;
    /**
     * @var TaskVo[]
     */
    public $taskVoList = [];
    /**
     * @var int 运行记录保存条数。如果设置为 -1 则代表无限。（由于默认的文件缓存不能太大，所以需要设定一个限制）
     */
    public $recordLimit = 10000;

    /**
     * 初始化数
     */
    public function onInit() {
        parent::onInit();
        $this->store = new CronFileStoreAo();
    }

    /**
     * @param TaskVo[] $taskVoList
     */
    public function setTaskVoList(array $taskVoList) {
        $this->taskVoList = $taskVoList;
    }
}