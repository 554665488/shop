<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-2
 * Time: 18:13
 */

namespace app\model;


use think\Model;

class Base extends Model
{
    /**
     * @description:软删除数据删除
     * @time: 2018年6月2日17:56:17
     * @Author: yfl
     * @QQ 554665488
     * @param $goods_ids:一个或者多个1,2 或者[1,2]
     * @param bool $flog:是否真的删除
     * @return int
     */
    public static function delGoods($goods_ids,$flog=false)
    {
        return self::destroy($goods_ids,$flog);
    }
}