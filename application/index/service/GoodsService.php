<?php
namespace app\index\service;
use app\model\Goods;
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
    /**
     * @description:获取商品分类信息
     * @time:2018-6-10 00:27:02
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function getGoodsCategory()
    {
        return Tree::recursiveMakeTree(GoodsCategory::all()->toArray(),'category_id');
   }
    //获取商品详情信息  TODO 待完成
    public function getGoodsDetail($goods_id)
    {
        $goods = Goods::where('goods_id='.$goods_id)
            ->with('goodsSku,shop,albumPicture,category_1,category_2,category_3')->select()->toArray();

        //获取登录用户等级
        //因为我们目前没有登录，所以需要一个标记
        $member_discount = 1;
        if($member_discount == 1)
        {
            //是会员的时候
            $goods['is_show_memner_price'] = 0;
        }else{
            //不是是会员的时候
            $goods['is_show_memner_price'] = 1;
        }

        //会员价格
        $goods['member_price'] =  $member_discount * $goods['price'];

        //sku价格
        foreach($goods['goods_sku'] as $key =>$value){
            $goods['goods_sku'][$key]['member_price'] = $value['price'] * $member_discount;
        }

        //获取商品图片
        $goods['img_list'] = $this->getGoodsImages($goods['img_id_array']);

        return $goods;
    }
}