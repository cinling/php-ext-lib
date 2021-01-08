<?php


namespace cin\extLib\vos\api\sqb;


use cin\extLib\vos\BaseVo;

/**
 * Class SqbActivateBizResponse
 * @package cin\extLib\vos\api\sqb
 */
class SqbBizResponse extends BaseVo {

    /**
     * @var string 终端编号
     */
    public $terminal_sn;
    /**
     * @var string 终端密钥
     */
    public $terminal_key;
}