<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-3
 * Time: 23:45
 */

namespace app\model;
/**
 * Class AlbumPicture
 * @package app\model
 * @description:相册图片
 * @time:
 * @Author: yfl
 * @QQ 554665488
 */

class AlbumPicture extends Base
{
    protected $pk = 'pic_id';

    /**
     * @description:一个相册记录相对关联属于一件商品
     * @time:2018-6-10 03:33:07
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo('User');
    }
}