<?php

namespace app\common\SendCodeUtil;
use app\common\RegisterSendCode;
use PHPMailer\PHPMailer\PHPMailer;
use think\facade\Log;

/**
 * Class EmailSendService
 * @package app\common\RegisterSendCodeInstance
 * @description:发送邮箱验证码服务实现
 * @time:2018年6月15日21:58:09
 * @Author: yfl
 * @QQ 554665488
 */
class EmailSendUtil extends RegisterSendCode
{
    // SMTP服务器用户名
    private $username = "13589233319@163.com";

    // SMTP服务器密码
    private $password = "Wangyi554665488";

    // SMTP 服务器
    private $host = "smtp.163.com";

    // SMTP服务器的端口号
    private $port = 465;

    // 邮件标题
    private $subject = "测试发送-邮件标题";

    private $smtpDebug = 0; // 0关闭, 1, 2开启

    private $mail;

    /**
     * @description:发送邮件
     * @time:2018年6月17日22:48:20
     * @Author: yfl
     * @QQ 554665488
     * @param $sendTo
     * @param string $content
     * @return array|bool|mixed
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendVerification($sendTo, $content = ''){
        if (!isset($sendTo)) {
            return false;
        }

        // 验证信息
        $content = ($content == '') ? sprintf($this->temp, $this->createCode()) : $content ;

        $this->mail = new PHPMailer();                            // PHPMailer对象
        $this->mail->CharSet = 'UTF-8';                           // 设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $this->mail->IsSMTP();                                    // 设定使用SMTP服务
        $this->mail->SMTPDebug = 2;                // 关闭SMTP调试功能
        $this->mail->SMTPAuth = true;                             // 启用 SMTP 验证功能
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->SMTPSecure = '';                             // 使用安全协议
        $this->mail->Host = $this->host;                          // SMTP 服务器
        $this->mail->Port = $this->port;                          // SMTP服务器的端口号
        $this->mail->Username = $this->username;                  // SMTP服务器用户名
        $this->mail->Password = $this->password;                  // SMTP服务器密码
        $this->mail->Subject = $this->subject;                    // 邮件标题
        $this->mail->SetFrom($this->username, "测试发送1");
        $this->mail->MsgHTML($content);
        $this->mail->AddAddress($sendTo, "测试发送2");
        //使用HTML格式发送邮件
        $this->mail->IsHTML(true);
        return $this->sendResult($this->mail->Send());
    }

    public function sendResult($code){
        dump($this->mail->ErrorInfo);
        ($this->smtpDebug == 2 ) ? Log::write($this->mail->ErrorInfo) : '';

        return ($code) ? [
            'status' => true,
            'msg'    => '发送成功'
        ] : [
            'status' => false,
            'msg'    => '发送失败'
        ] ;
    }
}