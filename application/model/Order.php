<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-17
 * Time: 23:25
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\model;

/**
 * Class Order
 * @package app\model
 * @description: 系统订单
 * @time:2018年6月17日23:26:26
 * @Author: yfl
 * @QQ 554665488
 */
class Order extends Base
{
    /**
     * 数据表主键id
     *
     * @var string
     */
    protected $pk = "order_id";

    public function getOrderStatusAttr($value)
    {
        $data =  [
            0 => '待付款',
            1 => '待发货',
            2 => '待收货',
            3 => '已收货',  // 已收货
            4 => '交易成功',// 已收货
            5 => '已关闭',
            -1 => '退款中',
            -2 => '已退款',
        ];
        return $data[$value];
    }

    public function getIsEvaluateAttr($value)
    {
        $data =  [
            0 => '为未评价',
            1 => '为已评价',
            2 => '为已追评',
        ];
        return $data[$value];
    }
}