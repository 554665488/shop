<?php
namespace app\index\controller;

use app\index\service\GoodsService;
use app\index\service\ShopService;
use think\Controller;
use Request;
use Log;

class IndexController extends Controller
{
    //商品分类业务
    private $goodsService;
    //店铺业务
    private $shopService;
    //公告业务
    private $cmsService;
    //广告业务
    private $platformSservice;

    public function initialize()
    {
        $this->goodsService = new GoodsService();
        $this->shopService = new ShopService();

    }

    public function index()
    {
        return 'Welcome to my world author QQ554665488' . url('admin/index/index');
//        return $this->fetch('aa.html');
    }

}
