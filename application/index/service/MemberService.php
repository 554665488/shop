<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-19
 * Time: 13:25
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\service;

use app\model\MemberFavorites;
use think\db\Query;

/**
 * Class MemberService
 * @package app\index\service
 * @description:会员服务
 * @time:2018年6月19日14:30:38
 * @Author: yfl
 * @QQ 554665488
 */
class MemberService extends BaseService
{
    //获得会员中心的信息
    public function getMemberInfo()
    {
        if (!SC::getLoginSessionKey('index')) {
            return false; // 没有登录
        }
        $where = 'shop_id=1';
        //关联优惠券
        User::with([
            'coupon' => function (Query $query) use ($where) {
                //关联优惠券类型
                $query->with([
                    'couponType' => function (Query $query) {
                        $query->field('*');
                    }
                ])->where($where);
            },
            //关联会员积分
            'memberAccount' => function (Query $query) use ($where) {
                $query->where($where)->field([
                    'uid',
                    'sum(point)' => 'point', //积分
                    'sum(balance)' => 'balance', //余额
                    'sum(coin)' => 'coin' //
                ]);
            },
            //会员等级
            'member' => function (Query $query) {
                $query->with([
                    'memberLevel' => function (Query $query) {
                        $query->field('level_id');
                    }
                ])->field('*');
            }
        ])->where()->select()->toArray();
    }

    // 查找会员搜藏的商品和店铺
    public function getMemberFavoriteGoodsShop($shop_id)
    {
        $where = [
            ['uid', '=', $this->userInfo['uid']]
        ];
        $whereShop = ['shop', '=', $shop_id];
        MemberFavorites::with('shop,goods')->where()->select()->toArray();
    }
}