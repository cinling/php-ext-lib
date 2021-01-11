<?php


namespace cin\extLib\services;


use cin\extLib\cos\FtpClientCo;
use cin\extLib\exceptions\FtpException;
use cin\extLib\traits\FtpTrait;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\StringUtil;

/**
 * Class FtpClientService FTP 服务
 * @package cin\extLib\services
 */
class FtpClientService
{
    use SingleTrait;
    use FtpTrait;

    /**
     * @var FtpClientCo
     */
    protected $co;

    /**
     * @var mixed ftp链接
     */
    private $conn;

    /**
     * @var array[] 远端文件数结构。减少网络请求提升效率
     */
    private $remoteDirTree = [];

    /**
     * FtpService constructor.
     */
    protected function __construct() {
        $this->co = new FtpClientCo();
    }

    /**
     * 设置 ftp 链接信息
     * @param FtpClientCo $co
     */
    public function setCo(FtpClientCo $co) {
        $this->co = $co;
    }

    /**
     * @return FtpClientCo
     */
    public function getCo() {
        return $this->co;
    }

    /**
     * @throws FtpException
     */
    public function reconnect() {
        $this->close();
        $this->conn($this->co->host, $this->co->username, $this->co->password, $this->co->port, $this->co->timeout);
    }

    /**
     * 自动重连
     * @throws FtpException
     */
    protected function autoReconnect() {
        if (!$this->conn) {
            $this->reconnect();;
        }
    }

    /**
     * 链接FTP服务器
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string|int $port
     * @param int $timeout
     * @throws FtpException
     */
    public function conn($host, $username, $password, $port = 21, $timeout = 90) {
        $this->conn = static::_connect($host, $port, $timeout);
        if (!$this->conn) {
            throw new FtpException("FtpService.conn(): Cannot connect to ftp server");
        }
        static::_setOption($this->conn, FTP_TIMEOUT_SEC, $timeout);
        if (!static::_login($this->conn, $username, $password)) {
            throw new FtpException("FtpService.conn(): Login failed");
        }
    }

    /**
     * 上传文件
     * @param string $localFile
     * @param string $removeFile
     * @throws FtpException
     */
    public function upload($localFile, $removeFile) {
        $this->autoReconnect();
        $this->autoMakeRemoteDir(dirname($removeFile));
        if (!static::_put($this->conn, $removeFile, $localFile)) {
            throw new FtpException("FtpService.conn(): upload file failed: [localFile: " . $localFile . ", removeFile: " . $removeFile . "]");
        }
    }

    /**
     * 下载文件
     * @param string $removeFile
     * @param string $localFile
     * @throws FtpException
     */
    public function download($removeFile, $localFile) {
        $this->autoReconnect();
        if (static::_get($this->conn, $localFile, $removeFile)) {
            throw new FtpException("FtpService.conn(): download file failed: [localFile: " . $localFile . ", removeFile: " . $removeFile . "]");
        }
    }

    /**
     * 远端创建目录
     * @param $dir
     * @throws FtpException
     */
    public function remoteMkdir($dir) {
        static::_mkdir($this->conn, $dir);
    }

    /**
     * @param $dir
     * @return array
     * @throws FtpException
     */
    public function remoteLs($dir) {
        $excludeDirKeyDict = [
            "." => "",
            ".." => ""
        ];

        $rows = static::_rawList($this->conn, $dir);
        $dirs = [];
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $row = StringUtil::trimLeft($row, "/");
                if (isset($excludeDirKeyDict[$row])) {
                    continue;
                }
                $dirs[] = $row;
            }
        }
        return $dirs;
    }

    /**
     * 自动创建远端路径
     * @param $dir
     * @throws FtpException
     */
    public function autoMakeRemoteDir($dir) {
        if (empty($dir) || $dir === "/" || $dir == "\\") {
            return;
        }
        if (!$this->isRemoteDirExists($dir)) {
            $this->autoMakeRemoteDir(dirname($dir));
            static::_mkdir($this->conn, $dir);
        }
        $this->addRemoteDirTree($dir);
    }

    /**
     * 判断远端路径是否存在
     * @param string $dir
     * @return bool
     * @throws FtpException
     */
    private function isRemoteDirExists($dir) {
        $exists = $this->isRemoteDirExistsInTree(explode("/", $dir), $this->remoteDirTree);
        if (!$exists) {
            $exists = count($this->remoteLs($dir)) > 0;
        }
        if ($exists) {
            $this->addRemoteDirTree($dir);
        }
        return $exists;
    }

    /**
     * 从本地记录查询目录是否存在
     * @param $dirs
     * @param $node
     * @return bool
     */
    private function isRemoteDirExistsInTree(array $dirs, array $node) {
        if (count($dirs) === 0) {
            return true;
        }

        $dir = $dirs[0];
        unset($dirs[0]);
        if (isset($node[$dir])) {
            return $this->isRemoteDirExistsInTree(array_values($dirs), $node[$dir]);
        }

        return false;
    }

    /**
     * 建立本地的树结构
     * @param string $dir
     */
    private function addRemoteDirTree($dir) {
        $names = explode("/", $dir);
        $this->remoteDirTree = $this->addRemoteDirTreeNoteByDir($names, $this->remoteDirTree);
    }

    /**
     * @param array $dirs
     * @param array $node 目录对应的节点
     * @return array
     */
    private function addRemoteDirTreeNoteByDir(array $dirs, array $node = []) {
        if (empty($dirs)) {
            return $node;
        }
        $dir = $dirs[0];
        unset($dirs[0]);
        if (!isset($node[$dir])) {
            $node[$dir] = [];
        }
        $node[$dir] = $this->addRemoteDirTreeNoteByDir(array_values($dirs), $node[$dir]);
        return $node;
    }

    /**
     * 关闭FTP服务器
     * @throws FtpException
     */
    public function close() {
        if ($this->conn) {
            static::_close($this->conn);
        }
    }
}