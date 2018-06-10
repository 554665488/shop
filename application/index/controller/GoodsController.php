<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-10
 * Time: 16:05
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;

/**
 * Class GoodsController
 * @package app\index\controller
 * @description:前台商品控制器
 * @time:2018-6-10 16:06:33
 * @Author: yfl
 * @QQ 554665488
 */
class GoodsController extends IndexBaseController
{

    public function goodsInfo()
    {
         $this->setHead();
         return $this->fetch();
    }
}