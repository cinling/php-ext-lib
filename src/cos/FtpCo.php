<?php


namespace cin\extLib\cos;


/**
 * @deprecated 在 3.0.0 后删除
 * 已重命名未 FtpClientCo
 *
 * Class FtpCo ftp 配置
 * @package cin\extLib\cos
 */
class FtpCo extends BaseCo {
    /**
     * @var string 链接地址（域名。带 ftp:// 前缀）
     */
    public $host;
    /**
     * @var int 端口号
     */
    public $port;
    /**
     * @var string 登录账号
     */
    public $username;
    /**
     * @var string 登录密码
     */
    public $password;
    /**
     * @var int 超时
     */
    public $timeout = 90;
}