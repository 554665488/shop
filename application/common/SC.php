<?php

namespace app\common;

use Session;

/**
 * Created by PhpStorm.
 * @description: 系统session 管理工具
 * @time:2018-6-17 22:28:27
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-22
 * Time: 22:00
 */
class SC
{
    /**
     * 用户登录的session key
     */
    CONST LOGIN_MAKE_SESSION_KEY = 'LOGIN_MAKE_SESSION_KEY';
    /**
     * 权限信息
     * @var string
     */
    CONST USER_ROLE_SESSION = 'USER_ROLE_SESSION';
    /**
     * 用户信息
     */
    CONST USER_INFO_SESSION = 'USER_INFO_SESSION';
    /**
     * 注册验证码
     */
    CONST REGISTER_SEND_CODE = 'REGISTER_SEND_CODE';

    /**
     * @description:设置用户登录的key
     * @time: 2018-5-23 00:15:16
     * @Author: yfl
     * @QQ 554665488
     * @param bool $userKey
     * @param string $prefix
     * @return mixed
     */
    public function setLoginSessionKey($userKey = false, $prefix = 'admin')
    {
        Session::set(self::LOGIN_MAKE_SESSION_KEY, $userKey, $prefix);
    }


    /**
     * @description: 获得用户登录的key
     * @time: 2018年5月23日00:17:07
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function getLoginSessionKey($prefix = 'admin')
    {
        return Session::get(self::LOGIN_MAKE_SESSION_KEY, $prefix);
    }

    /**
     * @description:删除用户登录的key
     * @time: 2018-5-23 00:18:27
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function delLoginSessionKey($prefix = 'admin')
    {
        return Session::delete(self::LOGIN_MAKE_SESSION_KEY, $prefix);
    }

    /**
     * @description:把用户的信息保存到session中。
     * @time:2018年5月23日00:20:35
     * @Author: yfl
     * @QQ 554665488
     * @param $userInfo
     * @param string $prefix
     * @return mixed
     */
    public function setUserInfoSession($userInfo, $prefix = 'admin')
    {
        Session::set(self::USER_INFO_SESSION, $userInfo, $prefix);
    }

    /**
     * @description:返回保存在session中的用户信息
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function getUserInfoSession($prefix = 'admin')
    {
        return Session::get(self::USER_INFO_SESSION, $prefix);
    }
    /**
     * @description:删除保存在session中的用户信息
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function delUserInfoSession($prefix = 'admin')
    {
        return Session::delete(self::USER_INFO_SESSION, $prefix);
    }

    /**
     * @description:把权限保存到session中。
     * @time: 2018年5月23日00:21:45
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @param $userRole
     */
    public function setUserRoleSession($userRole, $prefix = 'admin')
    {
        Session::set(self::USER_ROLE_SESSION, $userRole, $prefix);
    }

    /**
     * @description:返回保存在session中的权限信息
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function getUserRoleSession($prefix = 'admin')
    {
        return Session::get(self::USER_ROLE_SESSION, $prefix);
    }

    /**
     * @description:缓存注册验证码
     * @time:2018年6月17日22:31:57
     * @Author: yfl
     * @QQ 554665488
     * @param $code
     * @param string $prefix
     * @return mixed
     */
    public function setRegisterCode($code, $prefix = 'admin')
    {
        return Session::set(self::REGISTER_SEND_CODE, $code, $prefix);
    }

    /**
     * @description:获取注册验证
     * @time:2018年6月17日22:33:05
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function getRegisterCode($prefix = 'admin')
    {
        return Session::get(self::REGISTER_SEND_CODE, $prefix);
    }

    /**
     * @description:删除缓存的注册验证码
     * @time:2018年6月18日19:10:31
     * @Author: yfl
     * @QQ 554665488
     * @param string $prefix
     * @return mixed
     */
    public function delRegisterCode($prefix = 'admin')
    {
        return Session::delete(self::REGISTER_SEND_CODE, $prefix);
    }
}