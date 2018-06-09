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

use app\model\ShopNavigation;

/**
 * Class ShopService
 * @package app\index\service
 * @description:首页导航
 * @time:2018年6月7日21:29:10
 * @Author: yfl
 * @QQ 554665488
 */
class ShopService
{
    public function getShopNavigationList($where = 'type=1', $page_index = 1, $page_size = 0)
    {
        return ShopNavigation::where($where)->page($page_index, $page_size)->order('sort', 'asc')->select()->toarray();
    }

}