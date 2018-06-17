<?php
namespace app\test\controller;

use think\Controller;
use app\common\Service;
use app\home\service\ShopService;

class Shoptest extends Controller
{
    /**
     * 店部业务类
     * @var ShopService
     */
    private $shopService;
    // 初始化方法
    public function initialize()
    {
        $this->shopService  = new ShopService;
    }

    public function getShopListTest()
    {
        return dump($this->shopService->getShopDetailedList());
    }

    public function getShopNavgationListTest()
    {
        return dump($this->shopService->getShopNavgationList());
    }

    public function getShopGoodsRankTest($value='')
    {
        return json($this->shopService->getShopGoodsRank([
            'shopWhere' => 'shop_id=41',
            'goodsWhere' => 'category_id=312',
        ], 'collects', 'desc'));
    }
}
