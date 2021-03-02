<?php


namespace cin\extLib\traits;


use cin\extLib\exceptions\HideException;
use cin\extLib\utils\StringUtil;

/**
 * Trait HttpTrait http插件
 * @package cin\extLib\traits
 */
trait HttpTrait {
    /**
     * 发送post请求
     * @param $url
     * @param $values
     * @param array $headers
     * @return string
     */
    public static function post($url, $values = [], $headers = ["Content-type:application/json"]) {
        $data = json_encode($values);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Allow redirect
        curl_setopt($curl, CURLOPT_MAXREDIRS, 20); // Redirect max num
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 发送get请求
     * @param $url
     * @param array $values
     * @param string[] $headers
     * @return false|string
     */
    public static function get($url, $values = [], $headers = ["Content-type:application/x-www-form-urlencoded"]) {
        $httpParams = http_build_query($values);
        if (!empty($httpParams)) {
            $prefix = StringUtil::has($url, "?") ? "&" : "?";
            $url .= $prefix . $httpParams;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Allow redirect
        curl_setopt($curl, CURLOPT_MAXREDIRS, 20); // Redirect max num
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 以xml格式提交数据
     * @param $url
     * @param $xml
     * @param string[] $headers
     * @return bool|string
     * @throws HideException
     */
    public static function postXml($url, $xml, $headers = ["Content-type; text/xml"]) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Allow redirect
        curl_setopt($curl, CURLOPT_MAXREDIRS, 20); // Redirect max num
        $output = curl_exec($curl);
        if ($error = curl_errno($curl)) {
            throw new HideException($error);
        }
        curl_close($curl);
        return $output;
    }
}
