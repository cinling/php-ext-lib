<?php


namespace cin\extLib\traits;

use cin\extLib\interfaces\IBaseApiCo;
use cin\extLib\services\LogService;
use cin\extLib\utils\ArrayUtil;
use cin\extLib\utils\JsonUtil;

/**
 * Trait ApiTractLogTrait api 请求跟中的方法
 * @package cin\extLib\traits
 */
trait ApiTractLogTrait {

    /**
     * @var IBaseApiCo
     */
    private $baseApiCo;

    /**
     * @param IBaseApiCo $baseApiConfVo
     * @deprecated Remove on 3.0.0 . Replace with setBaeApiCo()
     * @see ApiTractLogTrait::setBaseApiCo()
     */
    private function setBaseApiConfVo(IBaseApiCo $baseApiConfVo) {
        $this->baseApiCo = $baseApiConfVo;
    }

    /**
     * @param IBaseApiCo $baseApiCo
     */
    private function setBaseApiCo(IBaseApiCo $baseApiCo) {
        $this->baseApiCo = $baseApiCo;
    }

    /**
     * @param string $title 标题。一般是接口名字。如："收钱吧-签到"
     * @param string $url
     * @param mixed $params
     * @param string $response
     * @param array $ext 额外的记录数据
     */
    protected function apiTractLog($title, $url, $params, $response, $ext = []) {
        if ($this->baseApiCo->isLogTrace()) {
            LogService::getIns()->trace(JsonUtil::encode(ArrayUtil::merge([
                "url" => $url,
                "params" => $params,
                "response" => $response
            ], $ext)), "API：" . $title);
        }
    }
}