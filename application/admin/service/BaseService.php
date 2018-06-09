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
     * @param string $saveDir :文件保存到项目的目录/public/upload/
     * @param int $type //缩放模式看手册
     * @return mixed 返回文件到项目的路径
     */
    final  protected function makeImgThumb($imgPath, $width = 700, $height = 700, $saveDir = '/upload/', $type = Image::THUMB_SCALING)
    {
        if (isset($imgPath) && file_exists($imgPath)) {
            $image = Image::open($imgPath);
            $fileInfoArr = filePathToArr($imgPath);
            $thumbName=$fileInfoArr['filename'] . "_{$width},{$height}." . $fileInfoArr['extension'];//缩略图名字拼接规则原文件名子._宽，高.ext
            $image->thumb($width, $height, $type)->save($fileInfoArr['dirname'] . '/' . $thumbName);
            return $saveDir .$thumbName ;
        }
    }

    /**
     * @description:缺失参数返回
     * @time:2018年5月21日00:04:57
     * @Author: yfl
     * @QQ 554665488
     * @param string $msg
     * @param bool $status
     * @param array $additional :额外返回的数据
     * @return \think\response\Json
     */
    final protected function deletionParam($msg = '', $status = true, array $additional = [])
    {
        $returnArray = [
            'msg' => $msg,
            'additional' => $additional,
            'status' => $status
        ];
        return json($returnArray);
    }
}