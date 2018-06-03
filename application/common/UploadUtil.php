<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-3
 * Time: 19:37
 */

namespace app\common;


use think\facade\Request;
use think\Image;

/**
 * @description:上传文件工具
 * @time:2018年6月3日20:42:10
 * @Author: yfl
 * @QQ 554665488
 * Class UploadUtil
 * @package app\common
 */
class UploadUtil
{
    private $fileName = 'file';// file的name
    private $uploadPath = PROJECT_ROOT . '/public/upload'; //上传路径
    private $savePath;
    private $ext = 'jpg,png,gif';
    private $size = 1024 * 1024 * 2;
    private $isSaveOldName = true;//是否以原图片名称

    /**
     * @description:上传单张图片
     * @time:2018年6月3日21:49:57
     * @Author: yfl
     * @QQ 554665488
     * @return array
     */
    public function uploadOne()
    {
        $file = Request::file($this->fileName);
        if (isset($this->savePath)) {
            $info = $file->validate(['size' => $this->size, 'ext' => $this->ext])->move($this->uploadPath . $this->savePath, $this->isSaveOldName);
        } else {
            $info = $file->validate(['size' => $this->size, 'ext' => $this->ext])->move($this->uploadPath, $this->isSaveOldName);
        }

        if ($info) {
            $oldName = $info->getInfo()['name'];
//            $ext = $info->getExtension();
            $uploadFilePath = $info->getSaveName();
        } else {
            $error = $file->getError();
        }
        if (isset($error)) return ['error_msg' => $error, 'status' => false];
        if (isset($uploadFilePath)) {
            return [
                'uploadFileInfo' => [
                    'path' => $uploadFilePath,
                    'old_file_name' => isset($oldName) ? $oldName : ''
                ],
                'status' => true
            ];
        }
    }

    /**
     * @description:上传多图
     * @time: 2018年6月3日19:53:19
     * @Author: yfl
     * @QQ 554665488
     * @return array
     */
    public function uploadMore()
    {
        $files = Request::file($this->fileName);
        $data = [];
        foreach ($files as $file) {
            if (isset($this->savePath)) {
                $info = $file->validate(['size' => $this->size, 'ext' => $this->ext])->move($this->uploadPath . $this->savePath, $this->isSaveOldName);
            } else {
                $info = $file->validate(['size' => $this->size, 'ext' => $this->ext])->move($this->uploadPath, $this->isSaveOldName);
            }
            if ($info) {
                $data[] = $info->getSaveName();
                $data[] = $info->getSaveName();
            } else {
                $error = $file->getError();
            }
        }
        if (isset($error)) return $error;
        return $data;
    }

    /**
     * @param mixed $savePath
     */
    public function setSavePath($savePath)
    {
        $this->savePath = $savePath;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName = '')
    {
        $this->fileName = $fileName == '' ? $this->fileName : $fileName;
    }

    /**
     * @param string $uploadPath
     */
    public function setUploadPath($uploadPath = '')
    {
        $this->uploadPath = $uploadPath == '' ? $this->uploadPath : $uploadPath;
    }

    /**
     * @param string $ext
     */
    public function setExt($ext = '')
    {
        $this->ext = $ext == '' ? $this->ext : $ext;
    }

    /**
     * @param int $size
     */
    public function setSize($size = 0)
    {
        $this->size = $size == 0 ? $this->size : $size;
    }

    /**
     * @param boolean $isSaveOldName
     */
    public function setIsSaveOldName($isSaveOldName = false)
    {
        $this->isSaveOldName = $isSaveOldName;
    }


}