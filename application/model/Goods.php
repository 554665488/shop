<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-26
 * Time: 22:44
 */

namespace app\model;


use think\Model;
use think\model\concern\SoftDelete;

/**
 * @description:商品模型
 * @time:2018年5月26日22:45:25
 * @Author: yfl
 * @QQ 554665488
 * Class Goods
 * @package app\model
 */
class Goods extends Base
{
    use SoftDelete;
    protected $pk = 'goods_id';
    protected $deleteTime = 'delete_time';

    /**
     * 关联商品分类
     *
     * @return Category       商品分类
     */
    public function category_1()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    /**
     * 关联商品分类
     *
     * @return Category       商品分类
     */
    public function category_2()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    /**
     * 关联商品分类
     *
     * @return Category       商品分类
     */
    public function category_3()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    /**
     * 关联图片
     *
     * @return AlbumPicture
     */
    public function albumPicture()
    {
        //                      关联表       关联表的主键    当前表的外键
        return $this->hasOne('AlbumPicture', 'pic_id',   'picture');
    }
    /**
     * 关联店铺
     *
     * @return Shop        店铺
     */
    public function shop()
    {
        return $this->hasOne('shop', 'shop_id', 'shop_id');
    }
}