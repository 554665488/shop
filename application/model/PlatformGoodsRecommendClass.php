<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:18
 */

namespace app\model;

/**
 * Class PlatformGoodsRecommendClass
 * @package app\model
 * @description:店铺商品推荐类别
 * @time:2018-6-10 02:04:47
 * @Author: yfl
 * @QQ 554665488
 */
/**
`class_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`class_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
`class_type` int(11) NOT NULL DEFAULT '1' COMMENT '推荐模块1.系统固有模块2.平台增加模块',
`is_use` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否使用',
`sort` int(11) NOT NULL DEFAULT '255' COMMENT '排序号',
`shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
 */
class PlatformGoodsRecommendClass extends Base
{
    protected $pk = 'class_id';

    /**
     * @description:关联平台商品关系表
     * @time:2018-6-10 03:02:13
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasMany
     */
    public function platformGoodsRecommend()
    {
        return $this->hasMany('PlatformGoodsRecommend', 'class_id', 'class_id');
    }
}