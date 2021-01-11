<?php


namespace cin\extLib\services;

use cin\extLib\consts\WechatPay;
use cin\extLib\cos\WechatPayCo;
use cin\extLib\exceptions\HideException;
use cin\extLib\traits\ApiTractLogTrait;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\HttpUtil;
use cin\extLib\utils\UrlUtil;
use cin\extLib\utils\XmlUtil;
use cin\extLib\vos\api\wechatPay\WechatPayTransfersRequest;
use cin\extLib\vos\api\wechatPay\WechatPayTransfersResponse;
use cin\extLib\vos\api\wechatPay\WechatPayUnifiedorderNotify;
use cin\extLib\vos\api\wechatPay\WechatPayUnifiedorderRequest;
use cin\extLib\vos\api\wechatPay\WechatPayUnifiedorderResponse;

/**
 * Class WechatPayService
 * 微信支付、微信商户号 服务
 * @package cin\extLib\services
 */
class WechatPayService {
    use SingleTrait;
    use ApiTractLogTrait;

    /**
     * @var WechatPayCo
     */
    protected $co;

    /**
     * WechatPayService constructor.
     */
    protected function __construct() {
        $this->co = new WechatPayCo();
        $this->setBaseApiConfVo($this->co);
    }

    /**
     * 根据请求参数
     * @param $params
     * @return string
     */
    protected function getSign($params) {
        ksort($params);
        $strs = [];
        foreach ($params as $key => $value) {
            if (empty($value) || $key === "sign") {
                continue;
            }
            $strs[] = $key . "=" . $value;
        }
        $str = implode("&", $strs) . "&key=" . $this->co->secret;
        return md5($str);
    }

    /**
     * 使用证书提交微信数据
     * @param string $url 请求地址
     * @param string $xml 请求xml参数
     * @return bool|string
     * @throws HideException
     */
    protected function postXmlWithCert($url, $xml) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type; text/xml"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');//证书类型
        curl_setopt($curl, CURLOPT_SSLCERT, $this->co->pemCert);//证书
        curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLKEY, $this->co->pemKey);//密钥
        $output = curl_exec($curl);
        if ($error = curl_errno($curl)) {
            throw new HideException($error);
        }
        curl_close($curl);
        return $output;
    }

    /**
     * jsapi 统一下单接口
     * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1
     * @param $appid
     * @param $nonceStr
     * @param $body
     * @param $outTradeNo
     * @param $totalFee
     * @param $openid
     * @param string $notifyUrl
     * @param string $tradeType
     * @param string $spbillCreateIp
     * @param array $extParams
     * @return WechatPayUnifiedorderResponse
     * @throws HideException
     */
    protected function requestPay_unifiedorder($appid, $nonceStr, $body, $outTradeNo, $totalFee, $openid, $notifyUrl = "", $tradeType = "JSAPI", $spbillCreateIp = "", $extParams = []) {
        if (empty($spbillCreateIp)) {
            $spbillCreateIp = $_SERVER['REMOTE_ADDR'];
        }
        if (empty($notifyUrl)) {
            $notifyUrl = $this->co->notifyUrl;
        }

        $url = WechatPay::UrlJsapiUnifiedorder;

        $request = new WechatPayUnifiedorderRequest();
        $request->appid = $appid;
        $request->mch_id = $this->co->mchId;
        $request->nonce_str = $nonceStr;
        $request->body = $body;
        $request->out_trade_no = $outTradeNo;
        $request->total_fee = $totalFee;
        $request->openid = $openid;
        $request->notify_url = $notifyUrl;
        $request->trade_type = $tradeType;
        $request->spbill_create_ip = $spbillCreateIp;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $request->sign = $this->getSign($params);
        $requestXml = $request->toXml();
        $xml =  HttpUtil::postXml($url, $requestXml);
        $this->apiTractLog("微信支付-统一下单", $url, $requestXml, $xml);

        $attrs = XmlUtil::xmlToArray($xml);

        return WechatPayUnifiedorderResponse::init($attrs);
    }

    /**
     * 提现接口
     * @param string $mchAppid 公众号id 或 小程序id
     * @param string $partnerTradeNo 订单编号
     * @param string $desc 备注信息
     * @param string $openid 收款用户的openid
     * @param string $amount 提现金额。单位：分
     * @param string $nonceStr 随机字符串（用于加密）
     * @param string $reUserName 收款人真实姓名
     * @param array $extParams
     * @return WechatPayTransfersResponse
     * @throws HideException
     */
    protected function requestMmpaymktTransfers_promotion_transfers($mchAppid, $partnerTradeNo, $desc, $openid, $amount, $nonceStr, $reUserName = "", $extParams = []) {
        $checkName = $reUserName === "" ? WechatPay::CheckNameNo : WechatPay::CheckNameForce;

        $url = WechatPay::UrlTransfers;
        $request = new WechatPayTransfersRequest();
        $request->mch_appid = $mchAppid;
        $request->mchid = $this->co->mchId;
        $request->partner_trade_no = $partnerTradeNo;
        $request->desc = $desc;
        $request->openid = $openid;
        $request->amount = $amount;
        $request->check_name = $checkName;
        $request->re_user_name = $reUserName;
        $request->nonce_str = $nonceStr;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $request->sign = $this->getSign($params);
        $requestXml = $request->toXml();
        $xml =  $this->postXmlWithCert($url, $requestXml);
        $this->apiTractLog("微信支付-企业付款", $url, $requestXml, $xml);

        $attrs = XmlUtil::xmlToArray($xml);
        return WechatPayTransfersResponse::init($attrs);
    }

    /**
     * @return WechatPayUnifiedorderNotify
     */
    public function recvPayUnifiedorderNotify() {
        $content = file_get_contents("php://input");
        $requestUrl = UrlUtil::withoutDomain($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        $this->apiTractLog("微信支付回调", $requestUrl, "", $content);
        $attrs = XmlUtil::xmlToArray($content);
        return WechatPayUnifiedorderNotify::init($attrs);
    }
}