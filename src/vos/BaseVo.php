<?php


namespace cin\extLib\vos;

use cin\extLib\interfaces\Arrayable;
use cin\extLib\interfaces\Errorable;
use cin\extLib\interfaces\Verifiable;
use cin\extLib\traits\BaseVoTrait;

/**
 * Class BaseVo 基础类型的vo数据
 * @package cin\extLib\vos
 */
class BaseVo implements Arrayable, Verifiable, Errorable {
    use BaseVoTrait;
}
