<?php


namespace cin\extLib\aos;


use cin\extLib\exceptions\UploadFileAoException;
use cin\extLib\utils\FileUtil;
use cin\extLib\utils\ValueUtil;

/**
 * Class UploadFileAo
 * @package cin\extLib\aos
 */
class UploadFileAo extends BaseAo {
    /**
     * @var array 文件信息
     */
    protected $fileInfo;
    /**
     * @var string 保存的文件名字
     */
    protected $saveFilename;

    /**
     * @param string $name
     * @return UploadFileAo
     * @throws UploadFileAoException
     */
    public static function initByName($name = "file") {
        $vo = new UploadFileAo();
        $vo->loadByName($name);
        return $vo;
    }

    /**
     * @return string[]
     */
    public static function uploadErrLabels() {
        return [
            UPLOAD_ERR_OK => "上传成功",
            UPLOAD_ERR_INI_SIZE => "上传文件超过系统限制",
            UPLOAD_ERR_FORM_SIZE => "上传文件超过网站限制",
            UPLOAD_ERR_PARTIAL => "文件上传不完整。请重新上传",
            UPLOAD_ERR_NO_FILE => "没有文件被上传",
            UPLOAD_ERR_NO_TMP_DIR => "找不到上传临时文件。请重试",
            UPLOAD_ERR_CANT_WRITE => "文件保存失败。请重试",
        ];
    }

    /**
     * @param $uploadErrCode
     * @return string
     */
    public static function uploadErrLabel($uploadErrCode) {
        return ValueUtil::getValue(self::uploadErrLabels(), $uploadErrCode, "上传失败");
    }

    /**
     * @param string $name
     * @throws UploadFileAoException
     */
    public function loadByName($name = "file") {
        $fileInfo = $_FILES[$name];
        if (empty($fileInfo)) {
            throw new UploadFileAoException("请选择上传文件");
        } else if (!empty($fileInfo["error"])) {
            throw new UploadFileAoException(self::uploadErrLabel($fileInfo["error"]));
        }
        $this->fileInfo = $fileInfo;
    }

    /**
     * 上传文件的名字
     * @return string
     */
    public function getFilename() {
        return $this->fileInfo["name"];
    }

    /**
     * 获取保存后的文件名字
     * @return string
     */
    public function getSaveFilename() {
        return $this->saveFilename;
    }

    /**
     * 获取文件类型
     * @return string
     */
    public function getFileType() {
        return $this->fileInfo["type"];
    }

    /**
     * 获取文件大小。单位：字节
     * @return int
     */
    public function getSize() {
        return $this->fileInfo["size"];
    }

    /**
     * 获取上传文件系统内的临时路径
     * @return string
     */
    public function getTmpName() {
        return $this->fileInfo["tmp_name"];
    }

    /**
     * Save upload file
     * @param string $path It can be an absolute path or a relative path (relative to the currently running directory)
     * @param string $saveFilename Save the file path. If it is empty, it is generated randomly
     * @return string save full name of file
     */
    public function save($path, $saveFilename = "") {
        $this->saveFilename = !empty($saveFilename) ? $saveFilename : $this->getHash8Name();
        $savePath = str_replace("//", "/", $path . "/" . $this->saveFilename);
        $dirName = dirname($savePath);
        if (!file_exists($dirName)) {
            mkdir($dirName, 0755, true);
        }

        copy($this->getTmpName(), $savePath);
        return $savePath;
    }

    /**
     * 获取文件的8位哈希名字
     * @return string
     */
    protected function getHash8Name() {
        return FileUtil::getHash8Name($this->getFilename());
    }
}
