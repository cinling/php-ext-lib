<?php


namespace cin\extLib\traits;


use cin\extLib\interfaces\Arrayable;
use cin\extLib\utils\ArrayUtil;
use cin\extLib\vos\BaseVo;

trait XmlTrait {

    /**
     * @param mixed $values
     * @param string $rootTag 最外层标签。如果为空，则没有最外层标签
     * @return string
     */
    public static function toXml($values, $rootTag = "xml") {
        if ($values instanceof BaseVo || $values instanceof Arrayable) {
            return static::toXml($values->toArray(), $rootTag);
        }
        $xml = "";

        $hasRoot = !empty($rootTag);
        if ($hasRoot) {
            $xml .= "<" . $rootTag . ">";
        }
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $value = static::toXml($value, "");
            }
            $xml .= "<" . $key . ">" . $value . "</" . $key . ">";
        }
        if ($hasRoot) {
            $xml .= "</" . $rootTag . ">";
        }
        return $xml;
    }

    /**
     * 将xml数据转为数组
     * @note 该方法为临时解决方案
     * @param string $xml
     * @return mixed
     */
    public static function xmlToArray($xml) {
        libxml_disable_entity_loader(true);
        $xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode($xmlObj), true);
    }
}