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
     * @description:一对一关联 一件商品属于一个一级分类
     * @time:2018年6月10日03:27:263
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function category_1()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    /**
     * @description:一对一关联 一件商品属于一个二级分类
     * @time:2018年6月10日03:27:39
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function category_2()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    /**
     * @description:一对一关联 一件商品属于一个三级分类
     * @time:2018年6月10日03:27:59
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function category_3()
    {
        return $this->hasOne('GoodsCategory', 'category_id', 'category_id_1');
    }

    /**
     * @description:一对一关联  一件商品关联一条相册记录
     * @time:2018年6月10日03:28:51
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function albumPicture()
    {
        //                      关联表       关联表的主键    当前表的外键
        return $this->hasOne('AlbumPicture', 'pic_id',   'picture');
    }

    /**
     * @description:一对一关联  一件商品属于一个店铺
     * @time:2018年6月10日03:29:38
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function shop()
    {
        return $this->hasOne('shop', 'shop_id', 'shop_id');
    }
}