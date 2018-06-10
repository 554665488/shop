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
        return $this->hasOne('Goods','category_id_1','recommend_id');
    }
}