<?php


namespace cin\extLib\services;


use cin\extLib\cos\FileCacheCo;
use cin\extLib\traits\SingleTrait;
use cin\extLib\utils\EncryptUtil;
use cin\extLib\utils\FileUtil;
use cin\extLib\utils\TimeUtil;
use cin\extLib\vos\FileCacheConfigVo;
use cin\extLib\vos\FileCacheContentVo;

/**
 * Class FileCacheService 文件缓存服务。可以保存一些数据
 * @package cin\extLib\services
 */
class FileCacheService {
    use SingleTrait;

    /**
     * @var FileCacheCo 服务配置
     */
    private $co;

    protected function __construct() {
        $this->co = new FileCacheCo();
    }

    /**
     * @param FileCacheConfigVo $co 服务配置
     * @deprecated Remove on 3.0.0 . Instead by setCo()
     */
    public function setConfig(FileCacheConfigVo $co) {
        $this->co = $co;
    }

    /**
     * @param FileCacheCo $co
     */
    public function setCo(FileCacheCo $co) {
        $this->co = $co;
    }

    /**
     * 设置缓存
     * @param string $key
     * @param mixed $value
     * @param int $duration 缓存时长。单位：秒。0代表永久缓存（不限制）
     */
    public function set($key, $value, $duration = 0) {
        $path = $this->getSavePath($key);
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $contentVo = new FileCacheContentVo();
        $contentVo->expire = !empty($duration) ? TimeUtil::stamp() + $duration : 0;
        $contentVo->value = $value;
        file_put_contents($path, EncryptUtil::serialize($contentVo));
    }

    /**
     * 获取缓存数据
     * @param string $key
     * @return mixed|null
     */
    public function get($key) {
        $path = $this->getSavePath($key);
        $vo = $this->getContentVoByPath($path);
        if ($vo === null) {
            return null;
        } else if ($vo instanceof FileCacheContentVo) {
            if (!empty($vo->expire) && $vo->expire < TimeUtil::stamp()) {
                $this->del($key);
                return null;
            }
            return $vo->value;
        }
        return $vo;
    }

    /**
     * @param string $key 删除缓存
     */
    public function del($key) {
        $path = $this->getSavePath($key);
        if (!file_exists($path)) {
            return;
        }
        unlink($path);
    }

    /**
     * 清除所有缓存数据
     */
    public function clear() {
        $files = FileUtil::scanDir($this->co->path);
        foreach ($files as $file) {
            $filename = $this->co->path . "/" . $file;
            FileUtil::delFile($filename);
        }
    }

    /**
     * 释放缓存（将过期的数据删除）
     */
    public function free() {
        $files = FileUtil::scanDir($this->co->path);
        foreach ($files as $file) {
            $filename = $this->co->path . "/" . $file;
            $this->freeCache($filename);
        }
    }

    /**
     * 如果文件下所有目录都被清空，则删除本身
     * @param $filename
     */
    private function freeCache($filename) {
        if (is_dir($filename)) {
            $files = FileUtil::scanDir($filename);
            foreach ($files as $file) {
                $subFilename = $filename . "/" . $file;
                $this->freeCache($subFilename);
            }

            // 判断目录下还有没有问题，如果目录下没有文件，则清楚文件夹
            $files = FileUtil::scanDir($filename);
            if (empty($files)) {
                FileUtil::delFile($filename);
            }
        } else {
            $vo = $this->getContentVoByPath($filename);
            if ($vo !== null) {
                if (!empty($vo->expire) && $vo->expire < TimeUtil::stamp()) {
                    FileUtil::delFile($filename);
                }
            }
        }
    }

    /**
     * 通过文件路径获取文件
     * @param $path
     * @return FileCacheContentVo|null
     */
    private function getContentVoByPath($path) {
        if (!file_exists($path)) {
            return null;
        }
        $value = file_get_contents($path);
        return EncryptUtil::unSerialize($value);
    }

    /**
     * 获取文件保存路径。并自动创建目录
     * @param string $key
     * @return string
     */
    private function getSavePath($key) {
        $filename = EncryptUtil::sha1($key);
        return $this->co->path . "/" . $this->getRelativeFilename($filename);
    }

    /**
     * 获取相对于配置的路径
     * @param string $filename
     * @return string
     */
    private function getRelativeFilename($filename) {
        $dir = "";
        $len = strlen($filename);
        for ($i = 0; $i < $this->co->pathDeeps; $i++) {
            if (!empty($dir)) {
                $dir .= "/";
            }
            $startIndex = $i * $this->co->pathUnitLen;
            if ($startIndex + $this->co->pathUnitLen >= $len) {
                $startIndex = $len - $this->co->pathUnitLen - 1;
            }
            $dir .= substr($filename, $startIndex, $this->co->pathUnitLen);
        }

        return $dir . "/" . $filename . ".cache";
    }
}