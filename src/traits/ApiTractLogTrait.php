<?php


namespace cin\extLib\traits;

use cin\extLib\interfaces\IBaseApiConfVo;
use cin\extLib\services\LogService;
use cin\extLib\utils\ArrayUtil;
use cin\extLib\utils\JsonUtil;

/**
 * Trait ApiTractLogTrait api 请求跟中的方法
 * @package cin\extLib\traits
 */
trait ApiTractLogTrait {

    /**
     * @var IBaseApiConfVo
     */
    private $baseApiConfVo;

    /**
     * @param IBaseApiConfVo $baseApiConfVo
     */
    private function setBaseApiConfVo(IBaseApiConfVo $baseApiConfVo) {
        $this->baseApiConfVo = $baseApiConfVo;
    }

    /**
     * @param string $title 标题。一般是接口名字。如："收钱吧-签到"
     * @param string $url
     * @param mixed $params
     * @param string $response
     * @param array $ext 额外的记录数据
     */
    protected function apiTractLog($title, $url, $params, $response, $ext = []) {
        if ($this->baseApiConfVo->isLogTrace()) {
            LogService::getIns()->trace(JsonUtil::encode(ArrayUtil::merge([
                "url" => $url,
                "params" => $params,
                "response" => $response
            ], $ext)), "API：" . $title);
        }
    }
}