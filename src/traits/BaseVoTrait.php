<?php


namespace cin\extLib\traits;


use cin\extLib\aos\RuleAo;
use cin\extLib\services\ValidFactoryService;
use cin\extLib\utils\ArrayUtil;
use cin\extLib\utils\ExcelUtil;
use cin\extLib\utils\JsonUtil;
use cin\extLib\utils\StringUtil;
use cin\extLib\utils\XmlUtil;
use cin\extLib\vos\BaseVo;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception as PhpSpreadsheetWriterException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Trait BaseVoTrait
 * @package cin\extLib\traits
 */
trait BaseVoTrait {
    use ErrorTrait;
    use LabelTrait;
    use PropSortTrait;

    /**
     * @var array 配置
     */
    protected $__config = [];

    /**
     * 初始化列表 或 字典
     * @param mixed[] $rows
     * @return static[]
     */
    public static function initList($rows) {
        $voList = [];
        foreach ($rows as $key => $row) {
            $vo = new static();
            $vo->setAttrs($row);
            $voList[$key] = $vo;
        }
        return $voList;
    }

    /**
     * @param $json
     * @return static[]
     */
    public static function initListByJson($json) {
        $rows = JsonUtil::decode($json);
        return static::initList($rows);
    }

    /**
     * @param $xml
     * @return BaseVo|static
     */
    public static function initByXml($xml) {
        $vo = new static();
        $vo->loadByXml($xml);
        return $vo;
    }

    /**
     * 导出为excel数据
     * @param string $excelFilename 导出文件名（不包含后缀）。建议不包含特殊的字符，如："[]{},'\"等
     * @param static[] $vos 导出数据
     * @param string $sheetTitle 表格标签的名字（只有一个标签）
     * @param bool $autoSetWidth 自动设置宽度
     * @throws PhpSpreadsheetException
     * @throws PhpSpreadsheetWriterException
     */
    public static function export($excelFilename, $vos = [], $sheetTitle = "sheet1", $autoSetWidth = true) {
        if (count($vos) === 0) {
            $vos[] = new static();
        }
        $labels = [];
        foreach ($vos as $vo) {
            $arr = $vo->toArray();
            foreach ($arr as $key => $value) { // 将所有属性转为label。如果没有配置属性的翻译，则使用key作为字段
                $labels[$key] = $key;
            }
            $tmpLabels = $vo->labels();
            foreach ($tmpLabels as $key => $label) {
                $labels[$key] = $label;
            }
            // 排除不需要导出的字段
            $excludeProp = $vo->excludeExportProps();
            foreach ($excludeProp as $prop) {
                unset($labels[$prop]);
            }
            break;
        }
        $formArr = [array_values($labels)];
        foreach ($vos as $vo) {
            $row = [];
            $arr = $vo->toArray();
            unset($vo);
            foreach ($labels as $key => $value) {
                if (strlen(strval($arr[$key])) !== 0) {
                    $row[] = (string)$arr[$key];
                } else {
                    $row[] = "";
                }
            }
            $formArr[] = $row;
        }

        // 增大可用内存
        ini_set('memory_limit', '1024M');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($formArr);
        if ($autoSetWidth) {
            // 列宽数组
            $columnsLenArr = [];
            foreach ($formArr as $rows) {
                foreach ($rows as $columnIndex => $value) {
                    if (!isset($columnsLenArr[$columnIndex])) {
                        $columnsLenArr[$columnIndex] = 1;
                    }
                    $len = strlen($value);
                    $columnsLenArr[$columnIndex] = $len > $columnsLenArr[$columnIndex] ? $len : $columnsLenArr[$columnIndex];
                }
            }
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($sheetTitle);
            foreach ($columnsLenArr as $columnIndex => $len) {
                $letter = ExcelUtil::numToLetter($columnIndex + 1);
                $sheet->getColumnDimension($letter)->setWidth($len);
            }

        }
        $writer = new Xlsx($spreadsheet);
        Header("Content-type:  application/octet-stream ");
        Header("Accept-Ranges:  bytes ");
        Header("Content-Disposition:  attachment;  filename=\"" . $excelFilename . ".xlsx\"");
        header('Cache-Control: max-age=0');//禁止缓存
        $writer->save('php://output');
        exit();
    }

    /**
     * 到處為 excel 數據。可以帶圖片
     * TODO 未完成的方法
     * @param string $excelFilename excel 文件名（導出文件的名字）
     * @param static[] $vos
     * @param string $sheetTitle 默認工作表名字
     * @param array $imageFields
     * @param int $imageWidth 圖片寬度和高度。所有圖片都相同
     * @throws PhpSpreadsheetException
     * @throws PhpSpreadsheetWriterException
     *@deprecated 暂不可用
     */
    public static function exportWithImage($excelFilename, $vos = [], $sheetTitle = "sheet1", $imageFields = [], $imageWidth = 80) {
        // 增大可用内存
        ini_set('memory_limit', '1024M');

        if (count($vos) === 0) {
            $vos[] = new static();
        }
        $labels = [];
        foreach ($vos as $vo) {
            $arr = $vo->toArray();
            foreach ($arr as $key => $value) { // 将所有属性转为label。如果没有配置属性的翻译，则使用key作为字段
                $labels[$key] = $key;
            }
            $tmpLabels = $vo->labels();
            foreach ($tmpLabels as $key => $label) {
                $labels[$key] = $label;
            }
            // 排除不需要导出的字段
            $excludeProp = $vo->excludeExportProps();
            foreach ($excludeProp as $prop) {
                unset($labels[$prop]);
            }
            break;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

//        // 写入表头
//        $colIndex = 1;
//        foreach ($labels as $label) {
//            $letter = ExcelUtil::numToLetter($colIndex);
//            $sheet->getCell($letter . "1")->setValue($label);
//            $colIndex++;
//        }

//        // 写入数值
//        $rowIndex = 2;
//        foreach ($vos as $vo) {
//            $colIndex = 1;
//            foreach ($labels as $prop => $value) {
//                if (!$vo->hasProp($prop)) {
//                    continue;
//                }
//                $letter = ExcelUtil::numToLetter($colIndex);
//                $sheet->getCell($letter . $rowIndex)->setValue($value);
//
//                $colIndex++;
//            }
//            $rowIndex++;
//        }
        $writer = new Xlsx($spreadsheet);
        Header("Content-type:  application/octet-stream ");
        Header("Accept-Ranges:  bytes ");
        Header("Content-Disposition:  attachment;  filename=\"" . $excelFilename . ".xlsx\"");
        header('Cache-Control: max-age=0');//禁止缓存
        $writer->save('php://output');
        exit();
    }

    /**
     * @param $row
     * @return static
     */
    public static function init($row) {
        $vo = new static();
        $vo->setAttrs($row);
        return $vo;
    }

    /**
     * @param $json
     * @return static
     */
    public static function initByJson($json) {
        $row = JsonUtil::decode($json);
        if (!is_array($row)) {
            $row = [];
        }
        return static::init($row);
    }

    /**
     * 获取验证工厂服务
     * @return ValidFactoryService
     */
    protected static function getValidSrv() {
        return ValidFactoryService::getIns();
    }

    /**
     * BaseVo constructor.
     * @param array $config 预留构造函数。防止被使用
     */
    public function __construct($config = []) {
        $this->__config = $config;
        $this->onInit();
    }

    /**
     * 初始化数据
     */
    protected function onInit() {

    }

    /**
     * 排除的导出属性
     * @return string[]
     */
    public function excludeExportProps() {
        return [];
    }

    /**
     * 使用关系数组初始化对象数据
     * @param array $attrs
     */
    public function setAttrs($attrs) {
        foreach ($attrs as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * 使用 xml 加载数据
     * @param $xml
     */
    public function loadByXml($xml) {
        $obj = simplexml_load_string($xml);
        $arr = ArrayUtil::toArray($obj);
        foreach ($arr as $prop => $value) {
            if ($this->hasProp($prop)) {
                $this->$prop = $value;
            }
        }
    }

    /**
     * 转换为数组
     * @return array
     */
    public function toArray() {
        $attrs = get_object_vars($this);

        // 排除 __ 开头的变量
        foreach ($attrs as $prop => $value) {
            if (StringUtil::startWidth($prop, "__")) {
                unset($attrs[$prop]);
            }
        }
        $array = ArrayUtil::toArray($attrs);
        $this->arrayPropSort($array);
        return $array;
    }

    /**
     * @return string
     */
    public function toJson() {
        return JsonUtil::encode($this->toArray());
    }

    /**
     * @return string
     */
    public function toXml() {
        return XmlUtil::toXml($this->toArray());
    }

    /**
     * 判断对象中有无该属性
     * @param $prop
     * @return bool
     */
    public function hasProp($prop) {
        return property_exists($this, $prop);
    }

    /**
     * 验证是否合法
     * @return bool
     */
    public function valid() {
        $rules = $this->rules();
        foreach ($rules as $ruleVo) {
            foreach ($ruleVo->props as $prop) {
                $label = $this->label($prop);

                if (!property_exists($this, $prop)) {
                    $this->addError("不存在的字段名：" . $label);
                    continue;
                }
                foreach ($ruleVo->handles as $handle) {
                    $handle($this, $prop, $label, $this->$prop);
                }
            }
        }
        return !$this->hasError();
    }

    /**
     * @return RuleAo[]
     */
    public function rules() {
        return [];
    }
}