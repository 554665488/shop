<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-19
 * Time: 15:44
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\service;

use app\model\Order;

/**
 * Class OrderService
 * @package app\index\service
 * @description:订单的服务
 * @time:2018年6月19日15:47:26
 * @Author: yfl
 * @QQ 554665488
 */
class OrderService extends BaseService
{

    //获得不同状态的订单的数量
    public function getOrderStatusNum()
    {
        Order::where(['buyer_id', '=', $this->userInfo['uid']])->field([
                'count(1)' => 'allOrderCount',
                'sum(case order_status when 0 then 1 else 0 end)' => 'waitPayCount',//待付款数量
                'sum(case order_status when 1 then 1 else 0 end)' => 'waitDelivery',//代发货数量
                'sum(case order_status when 2 then 1 else 0 end)' => 'waitTheGoods',//代收货数量
                'sum(case order_status when 3 then 1 else 0 end)' => 'alreadyTheGoods',//已收货数量
                'sum(case order_status when 4 then 1 else 0 end)' => 'tradingSuccess',//交易成功数量
                'sum(case order_status when 5 then 1 else 0 end)' => 'closeOrder',//关闭订单数量
                'sum(case order_status when -1 then 1 else 0 end)' => 'refundLoading',//退款中数量
                'sum(case order_status when -2 then 1 else 0 end)' => 'alreadyRefund',//已退款数量
            ]
        )->select();
    }


    //获得订单列表 TODO 还没做
    public function getOrderList()
    {
        Order::where(['buyer_id', '=', $this->userInfo['uid']])->select();
    }
}