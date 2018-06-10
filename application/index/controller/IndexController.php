<?php

namespace app\index\controller;

use app\common\Service;
use app\index\service\CmsService;
use app\index\service\GoodsService;
use app\index\service\PlatformService;
use app\index\service\ShopService;

use Request;

class IndexController extends BaseController
{
    //商品分类业务
    private $goodsService;
    //店铺业务
    private $shopService;
    //公告业务
    private $cmsService;
    //广告业务
    private $platformService;

    public function initialize()
    {
        $this->goodsService = Service::access(INDEX_MODEL, 'GoodsService');
        $this->shopService = Service::access(INDEX_MODEL, 'ShopService');
        $this->cmsService = Service::access(INDEX_MODEL, 'CmsService');
        $this->platformService = Service::access(INDEX_MODEL, 'PlatformService');


    }

    public function index()
    {
        $this->setHead();
        //获取商品分类 TODO 获取字段待处理
        $getGoodsCategoryTreeArr = $this->goodsService->getGoodsCategory();
        //获取导航 TODO 获取字段待处理
        $shopNavigationList = $this->shopService->getShopNavigationList();
        //获取cms文章列表 TODO 获取字段待处理
        $cmsArticleList = $this->cmsService->getCmsArticle();
        $PlatformGoodsRecommendList = $this->platformService->getPlatformGoodsRecommendList();
        $this->assign([
            'goodsCategoryList' => $getGoodsCategoryTreeArr,
            'shopNavigationList' => $shopNavigationList,
            'cmsArticleList' => $cmsArticleList,
            'PlatformGoodsRecommendList'=>$PlatformGoodsRecommendList
        ]);
        return $this->fetch();
    }

}
