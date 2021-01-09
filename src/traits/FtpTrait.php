<?php


namespace cin\extLib\traits;


use cin\extLib\exceptions\FtpException;
use Closure;
use Error;
use Exception;

/**
 * Trait FtpTrait ftp 功能封装。捕捉所有的致命错误，转为 FtpException
 * @package cin\extLib\traits
 */
trait FtpTrait {
    /**
     * 兼容 php5.6 模式，尽可能捕捉错误
     * @param Closure $closure
     * @return false|resource
     * @throws FtpException
     */
    protected static function catchError(Closure $closure) {
        try {
            return $closure();
        } catch (Error $e) {
            throw new FtpException($e);
        } catch (Exception $e) {
            throw new FtpException($e->getMessage());
        }
    }

    /**
     * @param $hostname
     * @param int $port
     * @param int $timeout
     * @return false|resource
     * @throws FtpException
     */
    public static function _connect($hostname, $port = 21, $timeout = 90) {
        return static::catchError(function () use ($hostname, $port, $timeout) {
            return ftp_connect($hostname, $port, $timeout);
        });
    }

    /**
     * @param $ftp
     * @param $username
     * @param $password
     * @return false|resource
     * @throws FtpException
     */
    public static function _login($ftp, $username, $password) {
        return static::catchError(function() use ($ftp, $username, $password) {
            return ftp_login($ftp, $username, $password);
        });
    }

    /**
     * @param $ftp
     * @param $local_filename
     * @param $remote_filename
     * @param int $mode
     * @param int $offset
     * @return false|resource
     * @throws FtpException
     */
    public static function _get($ftp, $local_filename, $remote_filename, $mode = FTP_BINARY, $offset = 0) {
        return static::catchError(function () use ($ftp, $local_filename, $remote_filename, $mode, $offset) {
            return ftp_get($ftp, $local_filename, $remote_filename, $mode, $offset);
        });
    }

    /**
     * @param $ftp
     * @param $remote_filename
     * @param $local_filename
     * @param int $mode
     * @param int $offset
     * @return false|resource
     * @throws FtpException
     */
    public static function _put($ftp, $remote_filename, $local_filename, $mode = FTP_BINARY, $offset = 0) {
        return static::catchError(function () use ($ftp, $remote_filename, $local_filename, $mode, $offset) {
            return ftp_put($ftp, $remote_filename, $local_filename, $mode, $offset);
        });
    }

    /**
     * @param $ftp
     * @param $directory
     * @return false|resource
     * @throws FtpException
     */
    public static function _mkdir($ftp, $directory) {
        return static::catchError(function () use ($ftp, $directory) {
            return ftp_mkdir($ftp, $directory);
        });
    }

    /**
     * @param $ftp
     * @return false|resource
     * @throws FtpException
     */
    public static function _close($ftp) {
        return static::catchError(function () use ($ftp) {
            return ftp_close($ftp);
        });
    }

    /**
     * @param $ftp
     * @param $directory
     * @param bool $recursive
     * @return false|resource
     * @throws FtpException
     */
    public static function _rawList($ftp, $directory, $recursive = false) {
        return static::catchError(function () use ($ftp, $directory, $recursive) {
            return ftp_rawlist($ftp, $directory, $recursive);
        });
    }

    /**
     * @param $ftp
     * @param $option
     * @param $value
     * @return false|resource
     * @throws FtpException
     */
    public static function _setOption($ftp, $option, $value) {
        return static::catchError(function () use ($ftp, $option, $value) {
            return ftp_set_option($ftp, $option, $value);
        });
    }
}