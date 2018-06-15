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
class Components extends BaseController
{
    //广告业务
    private $platformAdvService;

    public function initialize()
    {
        $this->platformAdvService = new PlatformAdvService();
    }

    public function platformAdvList(Request $request)
    {
        if ($this->isHasParam('adv_id')) {
            return $this->error('');
        }
    }
}