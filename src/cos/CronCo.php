<?php


namespace cin\extLib\cos;


use cin\extLib\aos\CronFileStoreAo;
use cin\extLib\interfaces\ICronStore;
use cin\extLib\vos\corn\TaskVo;

/**
 * Class CronCo
 * @package cin\extLib\cos
 */
class CronCo extends BaseCo {
    /**
     * 读写 实例。默认提供文件缓存的实例
     * Save and get object instance. Here provide the File Store's instance
     * @var ICronStore
     * @var CronFileStoreAo Default instance
     * @deprecated make protected in 3.0.0 . use function getStore() instead it
     * @see CronCo
     */
    public $store = null;
    /**
     * @var TaskVo[]
     */
    public $taskVoList = [];
    /**
     * @var int The number of running records saved. If set to - 1, it means infinite. (since the default file cache cannot be too large, a limit needs to be set.)
     */
    public $recordLimit = 10000;
    /**
     * @var bool disabled record run log
     * @deprecated waiting for develop
     */
    public $disabledRecord = false;

    /**
     * init
     */
    public function onInit() {
        parent::onInit();
        $this->store = new CronFileStoreAo();
    }

    /**
     * @return ICronStore
     */
    public function getStore() {
        if ($this->store === null) {
            $this->store = new CronFileStoreAo();
        }
        return $this->store;
    }

    /**
     * @param ICronStore $store
     */
    public function setStore(ICronStore $store) {
        $this->store = $store;
    }

    /**
     * @param TaskVo[] $taskVoList
     */
    public function setTaskVoList(array $taskVoList) {
        $this->taskVoList = $taskVoList;
    }
}
