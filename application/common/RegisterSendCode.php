<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 21:46
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\common;


use SC;

/**
 * Class RegisterInfoCheck
 * @package app\common
 * @description:注册发送验证码（短信，邮箱）
 * @time:2018年6月15日21:48:03
 * @Author: yfl
 * @QQ 554665488
 */
abstract class RegisterSendCode
{
    // 验证码内容
    protected $codeSet = '1234567890';

    // 验证码的长度
    protected $length = 4;

    // 验证码模板
    protected $temp = "你的验证码为:%s,请不要把信息告诉别人";

    // 错误信息
    private $error;

    /**
     * @description:发送验证信息实现
     * @time:2018年6月15日21:50:44
     * @Author: yfl
     * @QQ 554665488
     * @param $sendTo :邮箱地址
     * @param string $content :发送的内容
     * @return mixed
     */
    abstract protected function sendVerification($sendTo, $content = '');

    /**
     * @description:发送结果处理实现
     * @time:2018年6月15日21:51:05
     * @Author: yfl
     * @QQ 554665488
     * @param $code
     * @return mixed
     */
    abstract protected function sendResult($code);

    /**
     * @description:生成验证码
     * @time:2018年6月17日22:18:44
     * @Author: yfl
     * @QQ 554665488
     * @return array|string
     */
    protected function createCode()
    {
        // 验证码
        $code = [];
        for ($i = 0; $i < $this->length; $i++) {
            $code[$i] = $this->codeSet[mt_rand(0, strlen($this->codeSet) - 1)];
        }
        // 对于生成的内容进行加密
        $code = implode('', $code);

        $secode = [
            // 把校验码保存到session
            'verify_code' => $this->authCode($code),
            // 验证码创建时间
            'verify_time' => time()
        ];
        SC::delRegisterCode('index');//创建前先清除一下缓存
        SC::setRegisterCode($secode,'index');
        return $code;
    }

    /**
     * @description:校验的验证码的正确性
     * @time:2018年6月17日22:22:01
     * @Author: yfl
     * @QQ 554665488
     * @param $code
     * @return bool
     */
    public function check($code)
    {
        $secode = SC::getRegisterCode('index');
        if (empty($secode)) {
            $this->error = "请获取验证码";
            return false;
        }
        // 验证码的有效时间  3分钟
        if (time() - $secode['verify_time'] > 180) {
            SC::delRegisterCode('index');
            $this->error = "验证信息时间过期";
            return false;
        }

        if (isset($code) && password_verify($code, $secode['verify_code'])) {
            SC::delRegisterCode('index');
            return true;
        } else {
            $this->error = "验证码信息错误";
            return false;
        }
    }

    /**
     * @description:把验证码加密在放到session中缓存
     * @time:2018年6月17日22:21:18
     * @Author: yfl
     * @QQ 554665488
     * @param $data
     * @return bool|string
     */
    protected function authCode($data)
    {
        return password_hash($data, 1);
    }

    public function getError()
    {
        return $this->error;
    }
}