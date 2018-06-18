<?php
namespace app\common\SendCodeUtil;
use app\common\RegisterSendCode;

/**
 * Class SmsSendService
 * @description:发送短信验证码实现
 * @time:2018年6月15日21:56:15
 * @Author: yfl
 * @QQ 554665488
 */
class SmsSendUtil extends RegisterSendCode
{
    private $username = '13589233319';

    private $password = 'duanxin554665488';

    // 请求短信发送接口
    private $smsapi = "http://api.smsbao.com/";

    /**
     * @description:发送短信发送实现
     * @time:2018年6月15日21:54:32
     * @Author: yfl
     * @QQ 554665488
     * @param $sendTo:手机号
     * @param string $content:发送的内容
     * @return array|bool|mixed
     */
    public function sendVerification($sendTo, $content = ''){
        if (!isset($sendTo) && !isset($content)) {
            return false;
        }
        // 验证信息
        $content = ($content == '') ? sprintf($this->temp, $this->createCode()) : $content ;
        $sendurl = $this->smsapi."sms?u=".$this->username."&p=".md5($this->password)."&m=".$sendTo."&c=".urlencode($content);

        return $this->sendResult(file_get_contents($sendurl));
    }

    /**
     * @description:发送结果实现
     * @time:2018年6月15日21:55:02
     * @Author: yfl
     * @QQ 554665488
     * @param $code
     * @return array|mixed
     */
    public function sendResult($code){
        $statusStr = [
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        ];

        return ($code == 0) ? [
            'status' => true,
            'msg'    => $statusStr[$code]
        ] : [
            'status' => 'false',
            'msg'    => $statusStr[$code]
        ];
    }
}