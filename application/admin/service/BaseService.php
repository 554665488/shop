<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-3
 * Time: 22:28
 */

namespace app\admin\service;

use think\Image;

class BaseService
{
    /**
     * @description:制作图片缩略图
     * @time:2018年6月3日23:26:52
     * @Author: yfl
     * @QQ 554665488
     * @param $imgPath :文件的绝对路径
     * @param int $width :等比例缩放宽度
     * @param int $height :等比例缩放设置高度
     * @param int $type //缩放模式看手册
     * @return mixed 返回文件到项目的路径
     */
    final  protected function makeImgThumb($imgPath,$width = 700, $height = 700, $type = Image::THUMB_SCALING)
    {
        $absolutePath = PROJECT_ROOT . '/public' . $imgPath;//文件的绝对路径用来制作缩略图 TODO
        if (isset($absolutePath) && file_exists($absolutePath)) {
            $image = Image::open($absolutePath);
            $fileInfoArr = filePathToArr($absolutePath);
            $thumbNameArr=filePathToArr($imgPath);
            $thumbName = $thumbNameArr['filename'] . "_{$width},{$height}." . $fileInfoArr['extension'];//缩略图名字拼接规则原文件名子._宽，高.ext
            $image->thumb($width, $height, $type)->save($fileInfoArr['dirname'] . '/' . $thumbName);
            return $thumbNameArr['dirname'].'/' . $thumbName;
        }
    }

}