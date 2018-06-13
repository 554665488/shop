<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:25
 */

namespace app\admin\service;
use app\model\AlbumPicture;


/**
 * Class PlatformService
 * @package app\index\service
 * @description:后台相册的服务层
 * @time:2018-6-10 03:03:47
 * @Author: yfl
 * @QQ 554665488
 */
class AlbumPictureService extends BaseService
{
    /**
     * @description:相册的获取
     * @time:2018年6月12日17:40:42
     * @Author: yfl
     * @QQ 554665488
     * @param string $where
     * @param string $field
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsPicture($where = '1=1', $field = '*')
    {
         return AlbumPicture::where($where)->field($field)->select()->toArray();
    }

    /**
     * @description:处理上传商品的图片并制作缩略图保存到相册表
     * @time: 2018年6月4日00:00:35
     * @Author: yfl
     * @QQ 554665488
     * @param $imgPath :上传图片保存的路径用来生成缩略图
     * @return bool
     */
    public function GoodsImgSaveAlbumPicture($imgPath)
    {
        $data = [
            'pic_name' => $imgPath['uploadFileInfo']['old_file_name'],//原图名字
            'pic_cover' => '/upload/goods_img/' . $imgPath['uploadFileInfo']['path'],//上传的图片路径
        ];
        $data['pic_cover_big'] = $this->makeImgThumb($data['pic_cover'], 700, 700);//大图路径;
        $data['pic_size_big'] = '700,700';//大图大小
        $data['pic_cover_mid'] = $this->makeImgThumb($data['pic_cover'], 360, 360);//中图路径
        $data['pic_size_mid'] = '360,360';//中图大小
        $data['pic_cover_small'] = $this->makeImgThumb($data['pic_cover'], 240, 240);//小图路径
        $data['pic_size_small'] = '240,240';//小图大小
        $data['pic_cover_micro'] = $this->makeImgThumb($data['pic_cover'], 60, 60);//微图路径
        $data['pic_size_micro'] = '60,60';//微图大小
        $data['upload_time'] = getDateTime();
        $res = AlbumPicture::create($data);//create方法返回的是当前模型的对象实例 静态新增数据
        if ($res) {
            return $res->pic_id;
        } else {
            return false;
        }
    }
}