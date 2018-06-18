<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 21:38
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;

use app\index\service\UserService;
use think\facade\Request;

/**
 * Class LoginController
 * @package app\index\controller
 * @description:登录控制器
 * @time:2018年6月15日21:40:05
 * @Author: yfl
 * @QQ 554665488
 */
class LoginController extends BaseController
{
    public function login()
    {
        $this->setHead();

        if (Request::isPost()) {
            if ($this->isHasParam('account')) {
                return $this->ajaxReturnFail('账号不能为空');
            }
            if ($this->isHasParam('password')) {
                return $this->ajaxReturnFail('密码不能为空');
            }
            $account = Request::param('account');
            if (!isEmail($account) && !isMobile($account)) {
                return $this->ajaxReturnFail('账号为手机号或者邮箱');
            }
            $username = $account;
            $password = Request::param('password');
            $userService = new UserService();
            $result = $userService->login($username, $password);
            if ($result['code'] === true) {
                return $this->ajaxReturnSuccess($result['msg']);
            } else {
                return $this->ajaxReturnFail($result['msg']);
            }
        }
        return $this->fetch();
    }
}