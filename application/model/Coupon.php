<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-17
 * Time: 22:54
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\model;

/**
 * Class Coupon
 * @package app\model
 * @description:优惠券
 * @time:2018年6月17日22:54:29
 * @Author: yfl
 * @QQ 554665488
 */
class Coupon extends Base
{
    /**
     * 数据表主键id
     *
     * @var string
     */
    protected $pk = "coupon_id";

    /**
     * @description:关联优惠券类型表
     * @time:2018年6月19日10:44:06
     * @Author: yfl
     * @QQ 554665488
     * @return \think\model\relation\HasOne
     */
    public function couponType()
    {
        return $this->hasOne('CouponType','coupon_type_id','coupon_type_id');
    }
}