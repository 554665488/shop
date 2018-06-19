<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-10
 * Time: 0:16
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\controller;


use Request;
use think\Controller;

/**
 * Class IndexBaseController
 * @package app\index\controller
 * @description:前台基类
 * @time:2018年6月10日00:16:43
 * @Author: yfl
 * @QQ 554665488
 */
class BaseController extends Controller
{
    protected $head = [];

    public function initialize()
    {
        $this->setHead();
    }
    /**
     * @description:ajax请求参数验证
     * @time:2018年6月9日16:23:033
     * @Author: yfl
     * @QQ 554665488
     * @param $param:需要验证的field
     * @return bool
     */
    final public function isHasParam($param)
    {
        if(Request::isAjax()){
            if (!Request::has($param)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @description:设置head信息
     * @time:2018年6月10日00:23:343
     * @Author: yfl
     * @QQ 554665488
     * @param array $data
     */
    final protected function setHead($data = [])
    {
        $this->head['title'] = isset($data['title']) ? $data['title'] : '商城-个人学习使用';
        $this->head['keywords'] = isset($data['keywords']) ? $data['keywords'] : '商城-个人学习使用';
        $this->head['description'] = isset($data['description']) ? $data['description'] : '商城-个人学习使用';
        $this->assign('head', $this->head);
    }
    /**
     * @description:成功返回
     * @time:2018年5月21日00:04:57
     * @Author: yfl
     * @QQ 554665488
     * @param string $msg
     * @param bool $status
     * @param array $additional :额外返回的数据
     * @return \think\response\Json
     */
    final protected function ajaxReturnSuccess($msg = '', $status = true, array $additional = [])
    {
        $returnArray = [
            'msg' => $msg,
            'additional' => $additional,
            'status' => $status
        ];
        return json($returnArray);
    }

    /**
     * @description:失败返回
     * @time:2018年5月21日00:05:31
     * @Author: yfl
     * @QQ 554665488
     * @param string $msg
     * @param bool $status
     * @param array $additional :额外返回的数据
     * @return \think\response\Json
     */
    final protected function ajaxReturnFail($msg = '', $status = false, array $additional = [])
    {
        $returnArray = [
            'msg' => $msg,
            'additional' => $additional,
            'status' => $status
        ];
        return json($returnArray);
    }
}