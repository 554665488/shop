<?php
namespace app\test\controller;

use think\Controller;
use app\common\Service;
use Request,Config;
use SmsInfoCheck,EmailInfoCheck;

class Index extends Controller
{
    public function index()
    {
        // $t = SmsInfoCheck::sendVerification('17680143620');
        // dump($t);
        // dump(SmsInfoCheck::check(7565));
        // dump($t);
        // $t = EmailInfoCheck::sendVerification('2693754918@qq.com');
        // dump($t);
        // dump(EmailInfoCheck::check(8438));
        return view();
    }

    public function execute(Request $request)
    {
        $arr = $request::param();
        $modelName           = $arr['module'];
        $serviceClassName    = $arr['service'];
        $action              = $arr['action'];

        $class = 'app\\'.$modelName.'\\'.'service\\'.$serviceClassName;

        $service = new $class();

        return json(call_user_func_array([$service, $action],[]));
    }
}
