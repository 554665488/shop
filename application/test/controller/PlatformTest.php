<?php
namespace app\test\controller;

use think\Controller;
use app\common\Service;
use app\home\service\PlatformService;

class PlatformTest extends Controller
{

    /**
     * @var PlatformService
     */
    private $platformService;
    // 初始化方法
    public function initialize()
    {
        $this->platformService  = new PlatformService;
    }

    public function getPlatformBlockDetailedTest()
    {
        return dump($this->platformService->getPlatformBlockDetailed());
    }

    public function getPlatformAdvPositionDetailTest()
    {
        return dump($this->platformService->getPlatformAdvPositionDetailList('1051'));
    }
    /**
     * 推荐模块
     */
    public function getPlatformGoodsRecommendListTest()
    {
        return json($this->platformService->getPlatformGoodsRecommendList());
    }
}
