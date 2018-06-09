<?php
namespace app\index\service;
use app\model\GoodsCategory;
use Tree;
/**
 * Class GoodsService
 * @package app\index\service
 * @description: 商品业务
 * @time: 2018年6月7日20:51:05
 * @Author: yfl
 * @QQ 554665488
 */

class GoodsService extends BaseService
{
    public function getGoodsCategory()
    {
        return Tree::recursiveMakeTree(GoodsCategory::all()->toArray());
   }
}