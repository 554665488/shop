<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-29
 * Time: 20:59
 */

namespace app\model;


use think\Model;

/**
 * @description:商品模型
 * @time:2018年5月29日21:06:09
 * @Author: yfl
 * @QQ 554665488
 * Class Shop
 * @package app\model
 */
class Shop extends Model
{
    protected $pk = 'shop_id';

    /**
     * @description:关联店铺组
     * @time:2018年6月11日01:36:52
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function shopGroup()
    {
        return $this->hasOne('ShopGroup','shop_group_id','shop_group_id');
    }

    /**
     * @description:店部的入住等级 ： 如直营店铺，加盟店铺
     * @time:2018年6月11日01:43:39
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function ShopInstanceType()
    {

        return $this->hasOne('ShopInstanceType', 'instance_typeid', 'shop_type');
    }
}