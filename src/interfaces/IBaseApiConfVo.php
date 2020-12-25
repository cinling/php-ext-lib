<?php


namespace cin\extLib\interfaces;


/**
 * Interface IBaseApiConfVo api接口服务配置的接口
 * @package cin\extLib\interfaces
 */
interface IBaseApiConfVo {
    /**
     * @return bool 是否记录日期
     */
    public function isLogTrace();
}