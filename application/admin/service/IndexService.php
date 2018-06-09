<?php
namespace app\admin\service;

use app\model\Admin;
use Session;
use SC;

//登录业务处理
class IndexService
{
    /*public function text(){
        //return 'page老师好帅得';
        //return Admin::get(1);
    }*/
    //登录
    public static function login($username, $password)
    {
        $admin = Admin::with('adminRole')->where('user_name', '=', $username)->find();

//        //使用模型更新方式
//        $admin->password = password_hash($password,PASSWORD_DEFAULT);
//        $admin->save();
//        dump($admin);
        if (empty($admin)) {
            return ajaxReturn(false, '账号错误');
        }
//        if (!$admin->password == $password) {
        if (password_verify($password,$admin->password)==false) {
            return ajaxReturn(false, '密码错误');
        }

        if ($admin->adminRole->act_list == '0' || empty($admin->adminRole->act_list)) {
            return ajaxReturn(false, '该账号没有权限');
        }
        SC::setLoginSessionKey(true);
        SC::setUserRoleSession($admin->adminRole);
        SC::setUserInfoSession($admin);
        return ajaxReturn(true, '登录成功.');
    }
}