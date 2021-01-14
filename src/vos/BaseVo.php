<?php


namespace cin\extLib\vos;

use cin\extLib\interfaces\Arrayable;
use cin\extLib\interfaces\Errorable;
use cin\extLib\interfaces\Verifiable;
use cin\extLib\traits\BaseVoTrait;
use cin\extLib\traits\PropSortTrait;
use cin\extLib\traits\ErrorTrait;
use cin\extLib\traits\LabelTrait;
use cin\extLib\utils\ArrayUtil;
use cin\extLib\utils\ExcelUtil;
use cin\extLib\utils\JsonUtil;
use cin\extLib\utils\StringUtil;
use cin\extLib\utils\XmlUtil;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class BaseVo 基础类型的vo数据
 * @package cin\extLib\vos
 */
class BaseVo implements Arrayable, Verifiable, Errorable {
    use BaseVoTrait;
}
