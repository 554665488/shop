<?php
namespace app\common;

use Session;

/**
 * Created by PhpStorm.
 * @description:
 * @time:
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
     * @description:设置用户登录的key
     * @time: 2018-5-23 00:15:16
     * @Author: yfl
     * @QQ 554665488
     * @param bool $userKey
     * @return mixed
     */
    public function setLoginSessionKey($userKey = false)
    {
         Session::set(self::LOGIN_MAKE_SESSION_KEY, $userKey);
    }

    /**
     * @description: 获得用户登录的key
     * @time: 2018年5月23日00:17:07
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     */
    public function getLoginSessionKey()
    {
        return Session::get(self::LOGIN_MAKE_SESSION_KEY);
    }

    /**
     * @description:删除用户登录的key
     * @time: 2018-5-23 00:18:27
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     */
    public function delLoginSessionKey()
    {
        return Session::clear(self::LOGIN_MAKE_SESSION_KEY);
    }

    /**
     * @description:把用户的信息保存到session中。
     * @time:2018年5月23日00:20:35
     * @Author: yfl
     * @QQ 554665488
     * @param $userInfo
     * @return mixed
     */
    public function setUserInfoSession($userInfo)
    {
         Session::set(self::USER_INFO_SESSION, $userInfo);
    }

    /**
     * @description:返回保存在session中的所有用户信息
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     */
    public function getUserInfoSession()
    {
        return Session::get(self::USER_INFO_SESSION);
    }

    /**
     * @description:把权限保存到session中。
     * @time: 2018年5月23日00:21:45
     * @Author: yfl
     * @QQ 554665488
     * @param $userRole
     */
    public function setUserRoleSession($userRole)
    {
         Session::set(self::USER_ROLE_SESSION, $userRole);
    }

    /**
     * @description:返回保存在session中的权限信息
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     */
    public function getUserRoleSession()
    {
        return Session::get(self::USER_ROLE_SESSION);
    }
}