<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-10
 * Time: 0:16
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;


use app\common\Service;
use think\Controller;
use Request;
use think\facade\Config;

/**
 * Class IndexBaseController
 * @package app\index\controller
 * @description:前台首页
 * @time:2018年6月10日00:16:43
 * @Author: yfl
 * @QQ 554665488
 */
class IndexBaseController extends Controller
{
    protected $head = [];
    /**
     * @var $goodsService
     * @description: 商品分类业务
     */
    protected $goodsService;
    /**
     * @var $shopService
     * @description: 店铺业务
     */
    protected $shopService;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    /**
     * @description:全局初始化index模块的业务类 放到盒子里
     * @time:2018年6月10日16:35:29
     * @Author: yfl
     * @QQ 554665488
     */
    final protected function init()
    {
        $this->goodsService = Service::access(INDEX_MODEL, 'GoodsService');
        $this->shopService = Service::access(INDEX_MODEL, 'ShopService');
        $this->NavAndAdvGlobal();
        $this->isShowGoodsCateGory();
    }

    /**
     * @description:前台页面全局查找导航和商品分类
     * @time:2018年6月10日18:46:31
     * @Author: yfl
     * @QQ 554665488
     */
    final protected function NavAndAdvGlobal()
    {
        $this->assign([
            //获取商品分类 TODO 获取字段待处理
            'goodsCategoryList' => $this->goodsService->getGoodsCategory(),
            //获取导航 TODO 获取字段待处理
            'shopNavigationList' => $this->shopService->getShopNavigationList(),
        ]);
    }

    /**
     * @description初始化判断是否显示商品三级分类  有的页面不需要显示例如商品商品详情页面
     * @time:2018年6月10日19:24:57
     * @Author: yfl
     * @QQ 554665488
     */
    final protected function isShowGoodsCateGory()
    {
        $controller_action = strtolower(Request::controller()) . '/' . Request::action();
        if (in_array($controller_action,Config::get('indexConfig.showGoodsCateGory'))) {
            $this->assign([
                // 判断前台是否显示商品分类
                'categoryShow' => true,
            ]);
        }
    }

    /**
     * @description:设置head信息
     * @time:2018年6月10日00:23:343
     * @Author: yfl
     * @QQ 554665488
     * @param array $data
     */
    final protected function setHead($data = [])
    {
        $this->head['title'] = isset($data['title']) ? $data['title'] : '商城-个人学习使用';
        $this->head['keywords'] = isset($data['keywords']) ? $data['keywords'] : '商城-个人学习使用';
        $this->head['description'] = isset($data['description']) ? $data['description'] : '商城-个人学习使用';
        $this->assign('head', $this->head);
    }
}