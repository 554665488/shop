<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 15:06
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;

use app\index\service\PlatformAdvService;
use think\facade\Request;


/**
 * Class Components
 * @package app\index\controller
 * @description:平台组件控制器
 * @time:2018年6月15日15:22:08
 * @Author: yfl
 * @QQ 554665488
 */
class ComponentsController extends BaseController
{
    //广告业务
    private $platformAdvService;

    public function initialize()
    {
        $this->platformAdvService = new PlatformAdvService();
    }

    /**
     * @description:获得某一个位置的广告组件内容
     * @time:2018年6月15日18:07:09
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return bool|\think\response\Json
     */
    public function platformAdvList(Request $request)
    {
        if ($this->isHasParam('ap_id')) {
            return false;
        }
        $ap_id = (is_numeric($request::param('ap_id'))) ? $request::param('ap_id') : '1051' ;
        $result = $this->platformAdvService->getPlatformAdvPositionDetailList($ap_id);
//        halt($result);
        return (isset($result)) ? json($result[0]) : json(ajaxReturn(false, '没有数据')) ;
    }
}