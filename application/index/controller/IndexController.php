<?php
namespace app\index\controller;

use think\Controller;
use app\admin\logic\IndexLogic;
use Request;
use Log;

class IndexController extends Controller
{


    public function index()
    {
        return 'Welcome to my world author QQ554665488' . url('admin/index/index');
//        return $this->fetch('aa.html');
    }

}
