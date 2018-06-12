<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-20
 * Time: 23:55
 */

namespace app\admin\controller;


use think\Controller;
use think\facade\Request;

/**
 * @description:  admin基类
 * @time:2018年5月20日23:55:583
 * @Author: yfl
 * @QQ 554665488
 * Class BaseController
 * @package app\admin\controller
 */
class BaseController extends Controller
{
    protected $title;

    public function initialize()
    {
//        parent::initialize();

    }

    protected function setTitle($title)
    {
        $this->title = $title;
        $this->assign('title', $this->title);
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

    /**
     * @description:删除成功数据
     * @time: 2018年6月2日18:24:32
     * @Author: yfl
     * @QQ 554665488
     * @param string $msg
     * @param bool $status
     * @param array $additional
     * @return \think\response\Json
     */
    final protected function delAjaxReturnSuccess($msg = '删除成功', $status = true, array $additional = [])
    {
        $returnArray = [
            'msg' => $msg,
            'additional' => $additional,
            'status' => $status
        ];
        return json($returnArray);
    }

    /**
     * @description:删除成功数据
     * @time: 2018年6月2日18:24:32
     * @Author: yfl
     * @QQ 554665488
     * @param string $msg
     * @param bool $status
     * @param array $additional
     * @return \think\response\Json
     */
    final protected function delAjaxReturnFail($msg = '删除失败', $status = false, array $additional = [])
    {
        $returnArray = [
            'msg' => $msg,
            'additional' => $additional,
            'status' => $status
        ];
        return json($returnArray);
    }

    /**
     * @description:返回layui格式分页的数据
     * @time: 2018年6月2日16:05:50
     * @Author: yfl
     * @QQ 554665488
     * @param array $list
     * @param $count
     * @param string $msg
     * @param int $code
     * @return \think\response\Json
     */
    final  protected function returnLayuiPageData($list, $count, $msg = '', $code = 0)
    {
        return json([
            'code' => 0,
            'msg' => '',
            'data' => $list,
            'count' => $count
        ]);
    }

    /**
     * @description:ajax请求参数验证
     * @time:2018年6月9日16:23:033
     * @Author: yfl
     * @QQ 554665488
     * @param $param:需要验证的field
     * @return bool
     */
    final public function isAjaxHasParam($param)
    {
        if(Request::isAjax()){
            if (!Request::has($param)) {
                return true;
            } else {
                return false;
            }
        }
    }
}