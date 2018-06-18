<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:17
 */

namespace app\model;

/**
 * Class PlatformBlock
 * @package app\model
 * @description:首页促销模块
 * @time:2018年6月10日13:29:09
 * @Author: yfl
 * @QQ 554665488
 */
class PlatformBlock extends Base
{
    protected $pk = 'block_id';

    public function goodsCategory_1()
    {
        return $this->hasOne('Goods', 'category_id_1', 'recommend_id');
    }

    /**
     * 关联商品
     *
     * @return Goods       商品分类
     */
    public function goodsCategory_1_2()
    {
        return $this->hasOne('Goods', 'category_id_2', 'recommend_goods_category_1');
    }

    /**
     * 关联商品
     *
     * @return Goods
     */
    public function goodsCategory_1_3()
    {
        return $this->hasOne('Goods', 'category_id_3', 'recommend_goods_category_1');
    }

    /**
     * 关联广告 ：： 单广告位详情
     *
     * @return PlatformAdvPosition
     */
    public function apImage()
    {
        return $this->hasOne('PlatformAdvPosition', 'ap_id', 'recommend_ad_image');
    }

    /**
     * 关联广告 ：： 幻灯广告位
     *
     * @return PlatformAdvPosition
     */
    public function apSlide()
    {
        return $this->hasOne('PlatformAdvPosition', 'ap_id', 'recommend_ad_slide');
    }

    /**
     * 关联广告 ：： 多图广告位
     *
     * @return PlatformAdvPosition
     */
    public function apImages()
    {
        return $this->hasOne('PlatformAdvPosition', 'ap_id', 'recommend_ad_images');
    }
}