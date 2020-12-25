<?php


namespace cin\extLib\consts;

/**
 * Class Wechat 微信公众号（js-sdk）相关常量
 * @package cin\extLib\consts
 */
class Wechat {
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
}