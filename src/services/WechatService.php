<?php


namespace cin\extLib\services;

use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\HttpUtil;
use cin\extLib\utils\JsonUtil;
use cin\extLib\vos\api\wechat\WxJsSdkAccessTokenResponse;
use cin\extLib\vos\config\WechatConfVo;

/**
 * Class WechatService 微信公众号 js-sdk 接口
 * @package cin\extLib\services
 */
class WechatService {
    use SingleTrait;

    /**
     * 获取 access_token 的请求地址
     */
    const UrlAccessToken = "https://api.weixin.qq.com/cgi-bin/token";
    /**
     * 获取 js-sdk access_token 的请求地址
     *  https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
     */
    const UrlJsSdkAccessToken = "https://api.weixin.qq.com/sns/oauth2/access_token";
    /**
     * 刷新 access_token 的请求地址
     *  https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
     */
    const UrlRefreshToken = "https://api.weixin.qq.com/sns/oauth2/refresh_token";
    /**
     * 获取用户信息请求地址（只接受 GET 请求）
     *  https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
     */
    const UrlUserinfo = "https://api.weixin.qq.com/sns/userinfo";
    /**
     * 获取 jsapi_token
     *  GET https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
     */
    const UrlGetTicket = "https://api.weixin.qq.com/cgi-bin/ticket/getticket";
    /**
     * 获取媒体接口
     */
    const UrlMediaGet = "https://api.weixin.qq.com/cgi-bin/media/get";

    /**
     * @var WechatConfVo 微信公众号配置
     */
    protected $conf;

    /**
     * @param WechatConfVo $confVo 设置微信公众号配置
     */
    protected function setAppConf(WechatConfVo $confVo) {
        $this->conf = $confVo;
    }

    /**
     * 请求获取 js-sdk 的 access_token 的接口（这里的 access_token 和 公众号的 access_token 不同）
     * @param string $code 客户端 jscode
     * @return WxJsSdkAccessTokenResponse
     */
    private function requestSns_oauth2_accessToken($code) {
        $url = self::UrlJsSdkAccessToken;
        $params = [
            "appid" => $this->conf->appId,
            "secret" => $this->conf->appSecret,
            "code" => $code,
            "grant_type" => "authorization_code"
        ];

        $json = HttpUtil::post($url, $params);
        LogService::getIns()->trace(JsonUtil::encode([
            "url" => $url,
            "params" => $params,
            "response" => $json
        ]), "请求微信 access_token 接口");
        return WxJsSdkAccessTokenResponse::init(JsonUtil::decode($json));
    }

//    /**
//     * 刷新 access_token
//     * @param $refreshToken
//     * @return WxRefreshTokenResponse
//     */
//    private function requestSns_oauth2_refreshToken($refreshToken) {
//        $url = self::UrlRefreshToken;
//        $params = [
//            "appid" => $this->config->appid,
//            "grant_type" => "refresh_token",
//            "refresh_token" => $refreshToken,
//        ];
//        $json = HttpUtil::post($url, $params);
//        LogService::getIns()->trace(JsonUtil::encode([
//            "url" => $url,
//            "params" => $params,
//            "response" => $json
//        ]), "微信接口追踪");
//        return WxRefreshTokenResponse::init(JsonUtil::decode($json));
//    }
//
//    /**
//     * 请求获取用户信息
//     * @param $accessToken
//     * @param $openid
//     * @param string $lang
//     * @return WxUserinfoResponse
//     */
//    private function requestSns_userinfo($accessToken, $openid, $lang = "zh_CN") {
//        $url = self::UrlUserinfo . "?access_token=" . $accessToken . "&openid=" . $openid . "&lang=" . $lang;
//        $json = HttpUtil::get($url);
//        LogService::getIns()->trace(JsonUtil::encode([
//            "url" => $url,
//            "response" => $json
//        ]), "微信接口追踪");
//        return WxUserinfoResponse::init(JsonUtil::decode($json));
//    }
//
//    /**
//     * 获取 jsapi_token
//     * @param $accessToken
//     * @return WxGetTicketResponse
//     */
//    private function requestCgiBin_ticket_getTicket($accessToken) {
//        $url = self::UrlGetTicket . "?access_token=" . $accessToken . "&type=jsapi";
//        $json = HttpUtil::get($url);
//        LogService::getIns()->trace(JsonUtil::encode([
//            "url" => $url,
//            "response" => $json
//        ]), "微信接口追踪");
//        return WxGetTicketResponse::init(JsonUtil::decode($json));
//    }
//
//    /**
//     * 获取 access_token
//     */
//    private function requestCgiBin_token() {
//        $url = self::UrlAccessToken . "?grant_type=client_credential&appid=" . $this->config->appid . "&secret=" . $this->config->appsecret;
//        $json = HttpUtil::get($url);
//        LogService::getIns()->trace(JsonUtil::encode([
//            "url" => $url,
//            "response" => $json
//        ]), "微信接口追踪");
//        return WxAccessTokenResponse::init(JsonUtil::decode($json));
//    }
//
//    /**
//     * 获取下载资源的接口
//     * @param $accessToken
//     * @param $mediaId
//     * @return WxMediaGetResponse
//     */
//    private function requestCgiBin_media_get($accessToken, $mediaId) {
//        $url = self::UrlMediaGet . "?access_token=" . $accessToken . "&media_id=" . $mediaId;
//        $res = HttpUtil::get($url);
//
//
//        $logArr = ["url" => $url];
//        $attrs = JsonUtil::decode($res);
//        if (!$attrs) { // 解析失败，是二进制数据
//            $response = new WxMediaGetResponse();
//            $response->errcode = 0;
//            $response->errmsg = "";
//            $response->video_url = $url;
//        } else {
//            $logArr["response"] = $res;
//            $response = WxMediaGetResponse::init($attrs);
//        }
//        LogService::getIns()->trace(JsonUtil::encode($logArr), "微信接口追踪");
//
//        return $response;
//    }
}