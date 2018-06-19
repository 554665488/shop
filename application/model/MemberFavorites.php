<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-17
 * Time: 23:04
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\model;

/**
 * Class MemberFavorites
 * @package app\model
 * @description: 收藏表
 * @time:
 * @Author: yfl
 * @QQ 554665488
 */
class MemberFavorites extends Base
{
    /**
     * 数据表主键id
     *
     * @var string
     */
    protected $pk = "log_id";

    //关联搜藏的店铺  这里不是一对一吗
    public function shop()
    {
        return $this->hasMany('Shop', 'shop_id', 'fav_id');
    }

    //关联收藏的商品
    public function goods()
    {
        return $this->hasMany('Goods', 'goods_id', 'fav_id');
    }

}