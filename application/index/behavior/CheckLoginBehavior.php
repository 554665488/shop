<?php

namespace app\index\behavior;

use Config;
use think\Controller;
use Request;
use SC;

//行为钩子判断用户访问项目的状态


class CheckLoginBehavior extends Controller
{
    /**
     * @description:
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     */
    public function run(Request $request)
    {
        $controller_action = strtolower($request::controller()) . '/' . $request::action();
        if (!SC::getLoginSessionKey() || is_null(SC::getLoginSessionKey())) {
            //排除一些操作
            if (!in_array($controller_action, Config::get('except.admin'))) {
                return $this->error('请登录!', url('/admin/login'));
            }
        } else {
            if (in_array($controller_action, Config::get('except.admin'))) {
                return $this->error('登录成功!', url('/admin/Aindex'));
            }

        }
    }
}