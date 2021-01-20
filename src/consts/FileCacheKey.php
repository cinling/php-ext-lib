<?php


namespace cin\extLib\consts;


/**
 * Class FileCacheKey 文件缓存key
 * @package cin\extLib\consts
 */
class FileCacheKey {
    /**
     * 收钱吧-终端编号
     */
    const SqbTerminalSn = "CinSqbTerminalSn";
    /**
     * 收钱吧-终端密钥
     */
    const SqbTerminalKey = "CinSqbTerminalKey";
    /**
     * 收钱吧-签到标识
     */
    const SqbCheckinFlag = "CinSqbCheckinFlag";

    /**
     * 微信公众号（js-sdk）-access_token
     */
    const WechatAccessToken = "CinWechatAccessToken";
    /**
     * 微信公众号（js-sdk）-jsapi 的 access_token
     */
    const WechatOpenidJsSdkAccessToken = "CinWechatOpenidJsSdkAccessToken";
    /**
     * 微信公众号（js-sdk）-jsapi 的 refresh_token
     */
    const WechatOpenidJsSdkRefreshToken = "CinWechatOpenidJsSdkRefreshToken";
    /**
     * 微信公众号（js-sdk）-jsapi_ticket
     */
    const OpenidJsapiTicket = "CinOpenidJsapiTicket";

    /**
     * CronFileStoreAo: store task list
     */
    const CronTaskVoList = "CronFileStore_CacheTaskVoList";
    /**
     * CronFileStoreAo: store task record
     */
    const CronTaskRecordVoList = "CronFileStore_CacheTaskRecordVoList";
}