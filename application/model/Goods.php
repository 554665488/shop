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

    //关联商品分类——1
    public function category_1()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    //关联商品分类——2
    public function category_2()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    //关联商品分类——3
    public function category_3()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    public function shop()
    {
        return $this->hasOne('shop', 'shop_id', 'shop_id');
    }
}