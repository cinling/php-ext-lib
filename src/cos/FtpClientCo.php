<?php


namespace cin\extLib\cos;


/**
 * Class FtpCo ftp 配置
 * @package cin\extLib\cos
 */
class FtpClientCo extends BaseCo {
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