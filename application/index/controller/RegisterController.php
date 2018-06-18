<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 21:39
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;

use app\index\service\UserService;
use app\index\validate\RegisterValidate;
use EmailSendUtil;
use SmsSendUtil;
use think\facade\Request;

/**
 * Class RegisterController
 * @package app\index\controller
 * @description:注册控制器
 * @time:2018年6月15日21:40:58
 * @Author: yfl
 * @QQ 554665488
 */
class RegisterController extends BaseController
{
    private $userService;

    public function initialize()
    {
        parent::initialize();
        $this->userService = new UserService();
    }


    //手机注册
    public function register()
    {
        if (Request::isPost()) {
            $code = Request::param('code');
            if (!SmsSendUtil::check($code)) {
                return $this->ajaxReturnFail(SmsSendUtil::getError());
            }
            $params = Request::only(['phone', 'code', 'password', 'repassword', 'user_name']);
            $validate = new RegisterValidate();
            $data = [
                'user_tel' => isset($params['phone']) ? $params['phone'] : '',
                'code' => $params['code'],
                'password' => $params['password'],
                'repassword' => $params['repassword'],
                'user_name' => $params['user_name'],
                'reg_time' => getDateTime(),
            ];
            //验证信息
            if (!$validate->check($data)) {
                return $this->ajaxReturnFail($validate->getError());
            }
            $data['user_password'] = password_hash($data['repassword'], 1);
            $result = $this->userService->saveUser($data);
            if ($result['code']) {
                return $this->ajaxReturnSuccess('注册成功');
            } else {
                return $this->ajaxReturnFail($result['msg']);
            }

        }
        $this->assign('regType', 'register');
        return $this->fetch();
    }
    //邮箱注册

    /**
     * email注册
     */
    public function emailRegister()
    {
        if (Request::isPost()) {
            $code = Request::param('code');
            if (!EmailSendUtil::check($code)) {
                return $this->ajaxReturnFail(EmailSendUtil::getError());
            }
            $params = Request::only(['email', 'code', 'password', 'repassword', 'user_name']);
            $validate = new RegisterValidate();
            $data = [
                'user_email' => isset($params['email']) ? $params['email'] : '',
                'code' => $params['code'],
                'password' => $params['password'],
                'repassword' => $params['repassword'],
                'user_name' => $params['user_name'],
                'reg_time' => getDateTime(),
            ];
            //验证信息
            if (!$validate->check($data)) {
                return $this->ajaxReturnFail($validate->getError());
            }
            $data['user_password'] = password_hash($data['repassword'], 1);
            $result = $this->userService->saveUser($data);
            if ($result['code']) {
                return $this->ajaxReturnSuccess('注册成功');
            } else {
                return $this->ajaxReturnFail($result['msg']);
            }
        }
        $this->assign('regType', 'email');
        return $this->fetch();
    }

    /**
     * @description:判断用户是否存在
     * @time:2018年6月18日15:31:24
     * @Author: yfl
     * @QQ 554665488
     * @return \think\response\Json
     */
    public function ajaxIsUserExist()
    {
        if (Request::isPost()) {
            $account = Request::param('account');
            $result = $this->userService->getUserInfo($account);
            if (is_array($result) && !empty($result)) {
                return $this->ajaxReturnFail('该账户已存在');
            } else if ($result === false) {
                return $this->ajaxReturnFail('注册账户类型错误');
            } else {
                return $this->ajaxReturnSuccess('可以注册');
            }
        }
    }

    /**
     * @description:发送验证码
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @return string
     */
    public function sendCode()
    {
        if (Request::isPost()) {
            $sendTo = Request::param('sendTo');
            if (isMobile($sendTo)) {//发送手机号
                $result = SmsSendUtil::sendVerification($sendTo);
                if ($result['status'] === false) {
                    return $this->ajaxReturnFail($result['msg']);
                } else {
                    return $this->ajaxReturnSuccess($result['msg']);
                }
            } else if (isEmail($sendTo)) {//发送邮箱
                $result = EmailSendUtil::sendVerification($sendTo);
                if ($result['status'] === false) {
                    return $this->ajaxReturnFail($result['msg']);
                } else {
                    return $this->ajaxReturnSuccess($result['msg']);
                }
            } else {
                return $this->ajaxReturnFail('发送失败!');
            }
        }
    }
}