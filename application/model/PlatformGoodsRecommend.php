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
 * Class PlatformGoodsRecommend
 * @package app\model
 * @description:平台商品推荐 关联了推荐类别表 和商品表
 * @time:2018-6-10 02:08:35
 * @Author: yfl
 * @QQ 554665488
 */
/**
`recommend_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`goods_id` int(11) NOT NULL COMMENT '推荐商品ID',
`state` int(11) NOT NULL DEFAULT '1' COMMENT '推荐状态',
`class_id` int(11) NOT NULL DEFAULT '1' COMMENT '推荐类型',
`create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
`modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
 */
class PlatformGoodsRecommend extends Base
{
    protected $pk = 'recommend_id';
    /**
     * @description:关联推荐商品类别 一对一 一件商品属于一个类别
     * @time:2018年6月10日02:47:04
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function PlatformGoodsRecommendClass()
    {
        return $this->hasOne('PlatformGoodsRecommendClass', 'class_id', 'class_id');
    }

    /**
     * @description:关联商品 一对一
     * @time:2018-6-10 02:58:14
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function goods()
    {
        return $this->hasOne('Goods', 'goods_id', 'goods_id');
    }

    /**
     * @description:定义相对关联 商品关联记录属于一种商品分类
     * @time:2018-6-10 03:24:10
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\BelongsTo
     */
    public function toPlatformGoodsRecommendClass()
    {
      return $this->belongsTo('PlatformGoodsRecommendClass','class_id','class_id');
    }
}