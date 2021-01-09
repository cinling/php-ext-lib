<?php


namespace cin\extLib\exceptions;

use Error;

/**
 * Class FtpException ftp 异常
 * @package cin\extLib\exceptions
 */
class FtpException extends CinException {
    /**
     * @var Error
     */
    private Error $error;

    /**
     * @param Error $error
     * @return FtpException
     */
    public static function initByErrorException(Error $error) {
        $e = new FtpException();
        $e->message = $error->getMessage();
        $e->error = $error;
        return $e;
    }
}