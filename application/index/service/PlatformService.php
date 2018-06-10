<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:25
 */

namespace app\index\service;


use app\model\PlatformGoodsRecommendClass;
use think\db\Query;

/**
 * Class PlatformService
 * @package app\index\service
 * @description:推荐商品逻辑的处理
 * @time:2018-6-10 03:03:47
 * @Author: yfl
 * @QQ 554665488
 */
class PlatformService extends BaseService
{

    public function getPlatformGoodsRecommendList($where = '1 = 1')
    {
        /**
        [ sql ] [ SQL ] SELECT `goods_id`,`class_id` FROM `tp_platform_goods_recommend` WHERE  `class_id` IN (1,2,3,38,41,42,43) [ RunTime:0.001000s ]
        [ sql ] [ SQL ] SHOW COLUMNS FROM `tp_goods` [ RunTime:0.010001s ]
        [ sql ] [ SQL ] SELECT * FROM `tp_goods` WHERE (  `goods_id` IN (358,351,349,332,341,347,266,324,344,339,340,350,380,382,381,383,384,386,387,388,385,391,390,389) ) AND `tp_goods`.`delete_time` IS NULL [ RunTime:0.002000s ]
        [ sql ] [ SQL ] SHOW COLUMNS FROM `tp_album_picture` [ RunTime:0.008001s ]
        [ sql ] [ SQL ] SELECT * FROM `tp_album_picture` [ RunTime:0.002000s ]
        [ sql ] [ SQL ] SELECT * FROM `tp_album_picture` WHERE  `pic_id` IN (1844,1847,1849,1851,1853,1855,1857,1861) [ RunTime:0.001000s ]
         */
        return PlatformGoodsRecommendClass::with([
            'platformGoodsRecommend'=>function($query){
               $query->field('goods_id,class_id')->with(['goods'=>function(Query $query){
                   $query->field('*')->with(['albumPicture'=>function(Query $query){
                       $query->field('*')->select();
                   }]);
               }]);
            }
        ])->where($where)->select()->toArray();
//        return PlatformGoodsRecommendClass::with([
//            'PlatformGoodsRecommend' => [ //关联推荐模块
//                'goods' => [   //推荐模块中的上品
//                    'albumPicture'  //商品对应的图片
//                ]
//            ]
//        ])->where($where)->select()->toArray();

    }
}