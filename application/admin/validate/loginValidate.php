<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-20
 * Time: 22:55
 */

namespace app\admin\validate;


use think\Validate;

class loginValidate extends Validate
{
    protected $rule = [
        'username' => 'require|length:5,10|checkNoChinese:账号',
        'password' => 'require|length:6,12|checkNoChinese:账号',
        'verify' => 'require|length:5|checkNoChinese:验证码|checkCaptcha',

    ];

    protected $message = [
        'username'=>[
            'require'=>'名称必须',
            'length'=>'名称只能在5-10之间',
        ],
        'password'=>[
            'require'=>'密码必须',
            'length'=>'密码只能在6-12之间',
        ],
        'verify'=>[
            'require'=>'验证码必须',
            'length'=>'验证码长度必须为5位',
        ],

    ];

    /**
     * @description:
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @param $value :验证数据
     * @param $rule :返回的消息
     * @param array $data :全部数据（数组）
     * @return bool
     */
    protected function checkNoChinese($value, $rule, $data = [])
    {

        if (!preg_match("/^[A-Za-z0-9]+$/", $value)) {
            return $rule . '不能含有中文';
        }
        return true;
    }

    protected function checkCaptcha($value, $rule, $data = [])
    {

        if (!captcha_check($value)) {
            return '验证码错误';
        };
        return true;
    }
}