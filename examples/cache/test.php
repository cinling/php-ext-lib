<?php
require_once "../../vendor/autoload.php";

use cin\extLib\services\FileCacheService;
use cin\extLib\services\FtpService;


$fileCacheSrv = FileCacheService::getIns();

$fileCacheSrv->set("123", "312");
echo $fileCacheSrv->get("123");