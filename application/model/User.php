<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 19:00
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\model;

/**
 * Class User
 * @package app\model
 * @description:系统用户表
 * @time:2018年6月15日19:03:12
 * @Author: yfl
 * @QQ 554665488
 */
class User extends Base
{
    /**
     * 数据表主键id
     *
     * @var string
     */
    protected $pk = "uid";

    /**
     * @description:关联会员表
     * @time:
     * @Author: yfl
     * @QQ 554665488
     */
    public function member()
    {
        return $this->hasOne('Member', 'uid', 'uid');
    }

    /**
     * @description:关联优惠券表
     * @time:2018年6月19日10:41:05
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasMany
     */
    public function coupon()
    {
        return $this->hasMany('Coupon', 'coupon_id', 'uid');
    }

    /**
     * @description:关联会员账户统计
     * @time:2018年6月19日14:36:46
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasMany
     */
    public function memberAccount()
    {
        return $this->hasMany('MemberAccount', 'uid', 'uid');
    }
}