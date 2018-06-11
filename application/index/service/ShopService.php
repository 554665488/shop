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

use app\model\Shop;
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
    /**
     * @description:获取首页导航
     * @time:2018年6月10日01:33:373
     * @Author: yfl
     * @QQ 554665488
     * @param string $where:查询条件
     * @param int $page_index
     * @param int $page_size:获取几个导航
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getShopNavigationList($where = 'type=1', $page_index = 1, $page_size = 10)
    {
        return ShopNavigation::where($where)->page($page_index, $page_size)->field('nav_title,nav_url,nav_type,is_blank')->order('sort', 'asc')->select()->toarray();
    }

    /**
     * @description:返回商品店部详细的信息
     * @time:2018年6月11日01:44:53
     * @Author: yfl
     * @QQ 554665488
     * @param string $where
     * @param int $page_index
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getShopDetailedList( $where = ' 1 = 1',$page_index = 1, $page_size = 0)
    {
        return Shop::with('shopGroup,ShopInstanceType')->where($where)->page($page_index, $page_size)->select()->toArray();
    }

}