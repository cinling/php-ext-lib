<?php


namespace cin\extLib\services;

use cin\extLib\consts\FileCacheKey;
use cin\extLib\consts\Wechat;
use cin\extLib\exceptions\ApiException;
use cin\extLib\traits\ApiTractLogTrait;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\HttpUtil;
use cin\extLib\utils\JsonUtil;
use cin\extLib\utils\StringUtil;
use cin\extLib\vos\api\wechat\WechatAccessTokenRequest;
use cin\extLib\vos\api\wechat\WechatAccessTokenResponse;
use cin\extLib\vos\api\wechat\WechatGetTicketRequest;
use cin\extLib\vos\api\wechat\WechatGetTicketResponse;
use cin\extLib\vos\api\wechat\WechatMediaGetRequest;
use cin\extLib\vos\api\wechat\WechatMediaGetResponse;
use cin\extLib\vos\api\wechat\WechatRefreshTokenRequest;
use cin\extLib\vos\api\wechat\WechatTokenRequest;
use cin\extLib\vos\api\wechat\WechatTokenResponse;
use cin\extLib\vos\api\wechat\WechatUserinfoRequest;
use cin\extLib\vos\api\wechat\WechatUserinfoResponse;
use cin\extLib\vos\config\JsSdkConfigVo;
use cin\extLib\vos\config\WechatConfVo;

/**
 * Class WechatService 微信公众号 js-sdk 接口
 * @package cin\extLib\services
 */
class WechatService {
    use SingleTrait;
    use ApiTractLogTrait;

    /**
     * @var WechatConfVo 微信公众号配置
     */
    protected $conf;

    /**
     * WechatService constructor.
     */
    protected function __construct() {
        $this->conf = new WechatConfVo();
        $this->setBaseApiConfVo($this->conf);
    }

    /**
     * 请求获取 js-sdk 的 access_token 的接口（这里的 access_token 和 公众号的 access_token 不同）
     * @see https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#1
     * @param string $code 客户端 jscode
     * @param array $extParams 额外的请求参数（可覆盖原有参数）
     * @return WechatAccessTokenResponse
     */
    protected function requestSns_oauth2_accessToken($code, $extParams = []) {
        $url = Wechat::UrlJsSdkAccessToken;
        $request = new WechatAccessTokenRequest();
        $request->appid = $this->conf->appId;
        $request->secret = $this->conf->appSecret;
        $request->code = $code;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $json = HttpUtil::get($url, $params);
        $this->apiTractLog("微信-获取 js-sdk access_token", $url, $params, $json);
        return WechatAccessTokenResponse::initByJson($json);
    }

    /**
     * 刷新 access_token
     * @param $refreshToken
     * @param array $extParams
     * @return WechatTokenResponse
     */
    protected function requestSns_oauth2_refreshToken($refreshToken, $extParams = []) {
        $url = Wechat::UrlRefreshToken;
        $request = new WechatRefreshTokenRequest();
        $request->appid = $this->conf->appId;
        $request->refresh_token = $refreshToken;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $json = HttpUtil::post($url, $params);
        $this->apiTractLog("微信-刷新 js-sdk access_token", $url, $params, $json);
        return WechatTokenResponse::initByJson($json);
    }

    /**
     * 请求获取用户信息
     * @param $accessToken
     * @param $openid
     * @param array $extParams
     * @return WechatUserinfoResponse
     */
    protected function requestSns_userinfo($accessToken, $openid, $extParams = []) {
        $url = Wechat::UrlUserinfo;
        $request = new WechatUserinfoRequest();
        $request->access_token = $accessToken;
        $request->openid = $openid;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $json = HttpUtil::get($url, $params);
        $this->apiTractLog("微信-获取用户信息", $url, $params, $json);
        return WechatUserinfoResponse::initByJson($json);
    }

    /**
     * 获取 jsapi_token
     * @param $accessToken
     * @param array $extParams
     * @return WechatGetTicketResponse
     */
    protected function requestCgiBin_ticket_getTicket($accessToken, $extParams = []) {
        $url = Wechat::UrlGetTicket;
        $request = new WechatGetTicketRequest();
        $request->access_token = $accessToken;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $json = HttpUtil::get($url, $params);
        $this->apiTractLog("微信-获取 jsapi_token", $url, $params, $json);
        return WechatGetTicketResponse::initByJson($json);
    }

    /**
     * 获取 access_token
     * @param array $extParams
     * @return WechatTokenResponse
     */
    protected function requestCgiBin_token($extParams = []) {
        $url = Wechat::UrlAccessToken;
        $request = new WechatTokenRequest();
        $request->appid = $this->conf->appId;
        $request->secret = $this->conf->appSecret;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $json = HttpUtil::get($url, $params);
        $this->apiTractLog("微信-获取 access_token", $url, $params, $json);
        return WechatTokenResponse::initByJson($json);
    }

    /**
     * 获取下载资源的接口
     * @param $accessToken
     * @param $mediaId
     * @param array $extParams
     * @return WechatMediaGetResponse
     */
    protected function requestCgiBin_media_get($accessToken, $mediaId, $extParams = []) {
        $url = Wechat::UrlMediaGet;
        $request = new WechatMediaGetRequest();
        $request->access_token = $accessToken;
        $request->media_id = $mediaId;
        $request->setExtParams($extParams);
        $params = $request->toArray();
        $res = HttpUtil::get($url, $params);
        $this->apiTractLog("微信-媒体下载", $url, $params, $res);

        $logArr = ["url" => $url];
        $attrs = JsonUtil::decode($res);
        if (!$attrs) { // 解析失败，是二进制数据
            $response = new WechatMediaGetResponse();
            $response->errcode = 0;
            $response->errmsg = "";
            $response->video_url = $url;
        } else {
            $logArr["response"] = $res;
            $response = WechatMediaGetResponse::init($attrs);
        }
        LogService::getIns()->trace(JsonUtil::encode($logArr), "微信接口追踪");

        return $response;
    }


    /**
     * 获取 accessToken
     * @return string
     * @throws ApiException
     */
    protected function getAccessToken() {
        $fileCacheSrv = FileCacheService::getIns();
        $accessToken = $fileCacheSrv->get(FileCacheKey::WechatAccessToken);
        if (empty($accessToken)) {
            $response = $this->requestCgiBin_token();
            if ($response->hasError()) {
                throw new ApiException("获取 access_token 失败：" . $response->errmsg);
            }
            $accessToken = $response->access_token;
            $fileCacheSrv->set(FileCacheKey::WechatAccessToken, $accessToken, $response->expires_in);
        }
        return $accessToken;
    }

    /**
     * 获取code后，请求以下链接获取access_token：
     *      https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
     * @see https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#0
     * @param string $openid 用户唯一标识
     * @return string
     * @throws ApiException
     */
    protected function getJsSdkAccessToken($openid) {
        $fileCacheSrv = FileCacheService::getIns();

        if (!empty($openid)) { // 读取缓存中的 access_token
            $cacheKey = $this->getJsSdkAccessTokenCacheKey($openid);
            $accessToken = $fileCacheSrv->get($cacheKey);
            if (!empty($accessToken)) {
                return $accessToken;
            }

            // 尝试通过 refresh_token 刷新 access_token
            $accessToken = $this->getJsSdkAccessTokenByRefreshToken($openid);
            if (!empty($accessToken)) {
                return $accessToken;
            }
        }
        throw new ApiException("登录验证已过期，请重新登录");
    }

    /**
     * 缓存 access_token
     * @param $openid
     * @param $accessToken
     * @param int $duration
     */
    protected function cacheAccessToken($openid, $accessToken, $duration = 7200) {
        $cacheKey = $this->getJsSdkAccessTokenCacheKey($openid);
        FileCacheService::getIns()->set($cacheKey, $accessToken, $duration);
    }

    /**
     * 通过 openid 获取 refresh_token 再请求获取新的 access_token
     * @param $openid
     * @return string
     */
    protected function getJsSdkAccessTokenByRefreshToken($openid) {
        $fileCacheSrv = FileCacheService::getIns();
        $cacheKey = $this->getJsSdkRefreshTokenCacheKey($openid);

        $refreshToken = $fileCacheSrv->get($cacheKey);
        if (!empty($refreshToken)) {
            $response = $this->requestSns_oauth2_refreshToken($refreshToken);
            if (!$response->hasError()) {
                $this->cacheAccessToken($openid, $response->access_token, $response->expires_in);
                return $response->access_token;
            } else {
                LogService::getIns()->error(JsonUtil::encode([
                    "response" => $response
                ]), "微信刷新 access_token");
            }
        }
        return "";
    }

    /**
     * 获取 access_token 的缓存key
     * @param $openid
     * @return string
     */
    protected function getJsSdkAccessTokenCacheKey($openid) {
        return FileCacheKey::WechatOpenidJsSdkAccessToken . $openid;
    }

    /**
     * 获取 refresh_token 缓存key
     * @param $openid
     * @return string
     */
    protected function getJsSdkRefreshTokenCacheKey($openid) {
        return FileCacheKey::WechatOpenidJsSdkRefreshToken . $openid;
    }

    /**
     * 获取 jsapi_ticket
     *
     * @note 由于获取jsapi_ticket的api调用次数非常有限，频繁刷新jsapi_ticket会导致api调用受限，影响自身业务，开发者必须在自己的服务全局缓存jsapi_ticket 。
     * @param string $openid
     * @return string
     * @throws ApiException
     */
    protected function getJsapiTicket($openid) {
        $fileCacheSrv = FileCacheService::getIns();
        $cacheKey = $this->getJsapiTicketCacheKey($openid);
        $jsapiTicket = $fileCacheSrv->get($cacheKey);
        if (!empty($jsapiTicket)) {
            return $jsapiTicket;
        }

        $accessToken = $this->getAccessToken();
        $response = $this->requestCgiBin_ticket_getTicket($accessToken);
        if ($response->hasError()) {
            if ($response->errcode == Wechat::ErrorCodeAccessTokenExpired) {
                $fileCacheSrv->del(FileCacheKey::WechatAccessToken);
            }
            throw new ApiException("获取 jsaip_ticket 失败：" . $response->errmsg);
        }
        $fileCacheSrv->set($cacheKey, $response->ticket, $response->expires_in);
        return $response->ticket;
    }

    /**
     * 获取缓存 jsapi_ticket 的缓存key
     * @param $openid
     * @return string
     */
    protected function getJsapiTicketCacheKey($openid) {
        return FileCacheKey::OpenidJsapiTicket . $openid;
    }

    /**
     * 使用 js code 获取openid
     * @param $code
     * @return string
     */
    public function getOpenidByCode($code) {
        $response = $this->requestSns_oauth2_accessToken($code);
        if ($response->hasError()) {
            return "";
        }
        $this->cacheAccessToken($response->openid, $response->access_token, $response->expires_in);
        return $response->openid;
    }

    /**
     * 通过openid获取微信用户信息
     * @param $openid
     * @return WechatUserinfoResponse
     * @throws ApiException
     */
    public function getUserinfo($openid) {
        $accessToken = $this->getJsSdkAccessToken($openid);
        if (empty($accessToken)) {
            throw new ApiException("获取 AccessToken 失败");
        }
        return $this->requestSns_userinfo($accessToken, $openid);
    }

    /**
     * 获取 js-sdk 前端初始化的对象数据
     * @param string $openid
     * @param string $webUrl 微信网站当前页面
     * @return JsSdkConfigVo
     * @throws ApiException
     */
    public function getJsSdkConfigVo($openid, $webUrl) {
        $vo = new JsSdkConfigVo();

        $vo->appId = $this->conf->appId;
        $vo->nonceStr = StringUtil::randStr(rand(8, 32));
        $vo->timestamp = strval(time());
        $jsapiTicket = $this->getJsapiTicket($openid);

        $encryptDict = [
            "noncestr" => $vo->nonceStr,
            "jsapi_ticket" => $jsapiTicket,
            "timestamp" => $vo->timestamp,
            "url" => $webUrl,
        ];

        ksort($encryptDict);
        $signStr = "";
        foreach ($encryptDict as $key => $value) {
            if (!empty($signStr)) {
                $signStr .= "&";
            }
            $signStr .= $key . "=" . $value;
        }
        $vo->signature = sha1($signStr);

        return $vo;
    }

    /**
     * 获取微信网页登录授权的重定向地址
     * @param string $redirectUrl 重定向跳转
     * @return string
     */
    public function getJsSdkRedirectUrl($redirectUrl) {
        $redirectUrl = urlencode($redirectUrl);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->conf->appId . "&redirect_uri=" . $redirectUrl . "&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    }

}