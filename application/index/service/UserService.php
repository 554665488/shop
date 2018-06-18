<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 21:42
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\service;

use app\model\MemberLevel;
use app\model\User;
use think\db\Query;
use SC;

/**
 * Class UserService
 * @package app\index\service
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 */
class UserService extends BaseService
{
    /**
     * @description:根据手机号 邮箱获查找用户
     * @time:2018年6月18日16:30:54
     * @Author: yfl
     * @QQ 554665488
     * @param $value
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserInfo($value)
    {
        if (isMobile($value)) {
            return User::where('user_tel', '=', $value)->select()->toArray();
        }
        if (isEmail($value)) {
            return User::where('user_email', '=', $value)->select()->toArray();
        }
        return false;
    }

    /**
     * @description:添加用户
     * @time:2018年6月18日13:01:39
     * @Author: yfl
     * @QQ 554665488
     * @param $params :用户注册信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function saveUser($params)
    {
        // 保存
        $user = new User;
        $params['user_password']=password_hash($params['repassword'], 1);
        $user->allowField(true)->save($params);

        // 会员默认等级
        $user->member()->save([
            'uid' => $user->uid,
            'member_name' => $user->user_name,
            'member_level' => MemberLevel::where('is_default', '=', '1')->value('level_id'),
            'reg_time' => getDateTime()
        ]);
        if (!$user) {
            return ajaxReturn(false, '用户信息保存错误');
        }
        // 用户登入
        return $this->login($user->uid, $params['repassword']);
    }

    /**
     * @description:用户注册成功后登录
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @param $user_account :是指登入的账号，可以是手机号码，可以是email
     * @param $password
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($user_account, $password)
    {
        // 查询用户
        $user_info = User::whereOr([
            ['user_tel', '=', $user_account],
            ['user_email', '=', $user_account],
            ['uid', '=', $user_account],
        ])->with(['member'=>function(Query $query){
            $query->field('uid,member_level')->with(['memberLevel'=>function(Query $query){
                $query->field('*');
            }]);
        }])->find();
        //验证登录信息
        if (!$user_info) {
            return ajaxReturn(false, '用户信息不存在');
        } else if (!password_verify($password, $user_info['user_password'])) {
            return ajaxReturn(false, '用户账号密码错误');
        } else if ($user_info['user_status'] == 0) {
            return ajaxReturn(false, '用户账号不允许登入，请联系官方处理');
        }
        // 缓存用户信息
        SC::setLoginSessionKey('user','index');
        SC::setUserInfoSession($user_info->toArray(),'index');
        // 记入用户的登入信息
        $data = [
            'last_login_time' => $user_info['current_login_time'],
            'last_login_ip' => $user_info['current_login_ip'],
            'last_login_type' => $user_info['current_login_type'],
            'current_login_ip' => request()->ip(),
            'current_login_time' => getDateTime(),
            'current_login_type' => 1
        ];
        $user_info->save($data);
        return ajaxReturn(true, '登入成功');
    }
}