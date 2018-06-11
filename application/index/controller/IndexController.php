<?php

namespace app\index\controller;

use app\common\Service;

use Request;
use think\Db;

class IndexController extends IndexBaseController
{

    //公告业务
    private $cmsService;
    //广告业务
    private $platformService;

    public function initialize()
    {

        $this->cmsService = Service::access(INDEX_MODEL, 'CmsService');
        $this->platformService = Service::access(INDEX_MODEL, 'PlatformService');

    }

    public function index()
    {
        $this->setHead();
        //平台店铺信息
        $shopDetailedList = $this->shopService->getShopDetailedList();
        //获取公告文章列表 TODO 获取字段待处理
        $cmsArticleList = $this->cmsService->getCmsArticle();
        //获取首页推荐的商品
        $PlatformGoodsRecommendList = $this->platformService->getPlatformGoodsRecommendList('class_type=2');//class_type 系统固有模块
//        _pre($PlatformGoodsRecommendList);
        $this->assign([
            'cmsArticleList' => $cmsArticleList,
            'platformGoodsRecommendList'=>$PlatformGoodsRecommendList,
            'shopDetailedList'=>[
                // 店部集合
                'data'            => $shopDetailedList,
                // 页面展示之后剩余的空位 预计只有18条数据
                'residueCount'    => 18 - count($shopDetailedList),
            ],
        ]);
//        _pre($shopDetailedList);
        return $this->fetch();
    }

}
