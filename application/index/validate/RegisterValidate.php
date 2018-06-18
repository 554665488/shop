<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-18
 * Time: 16:11
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\validate;

use app\index\service\UserService;
use think\Validate;

/**
 * Class RegisterValidate
 * @package app\index\validate
 * @description:注册验证
 * @time:2018年6月18日16:12:11
 * @Author: yfl
 * @QQ 554665488
 */
class RegisterValidate extends Validate
{
    protected $rule = [
        'user_tel' => 'length:11|mobile|IsUserExist:手机号',
        'user_email' => 'email|IsUserExist:邮箱',
        'code' => 'require|length:4|number',
        'password' => 'require|length:6,20',
        'repassword' => 'require|length:6,20|confirm:password',
        'user_name' => 'require|length:5,10|chsAlphaNum',
    ];

    protected $message = [
        'user_tel' => [
            'length' => '手机号只能11位',
            'mobile' => '请输入正确的手机号',
        ],
        'user_email' => [
            'email' => '请输入正确的邮箱',
        ],
        'code' => [
            'require' => '注册码必须填写',
            'length' => '注册码只能4位数字',
            'number' => '注册码只能为数字',
        ],
        'password' => [
            'require' => '密码必须填写',
            'length' => '密码只能在6-20字符之间',
        ],
        'repassword' => [
            'require' => '密码必须填写',
            'length' => '密码只能在6-20字符之间',
            'confirm' => '两次密码不一致',
        ],
        'user_name' => [
            'require' => '用户名必须',
            'length' => '名称只能在5-10字符之间',
            'chsAlphaNum' => '用户名只能是汉字、字母和数字',
        ],
    ];

    /**
     * @description::验证手机号是否存在
     * @time:2018年6月18日16:47:35
     * @Author: yfl
     * @QQ 554665488
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function IsUserExist($value, $rule, $data = [])
    {
        $userService = new UserService();
        $result = $userService->getUserInfo($value);
        if (is_array($result) && !empty($result)) {
            return $rule . '已经存在';
        }
        return true;
    }
}