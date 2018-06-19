<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-19
 * Time: 13:24
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;

use app\index\service\MemberService;
use app\model\User;
use SC;
use think\db\Query;

/**
 * Class MemberController
 * @package app\index\controller
 * @description:会员中心
 * @time:2018年6月19日13:25:043
 * @Author: yfl
 * @QQ 554665488
 */
class MemberController extends BaseController
{
    protected $memberService;

    public function initialize()
    {
        parent::initialize();
        $this->memberService = new MemberService();
    }

   // TODO 会员中心信息展示
    public function index()
    {
        $memberCenterInfo= $this->memberService->getMemberInfo();
    }
}