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


use think\Controller;

/**
 * Class BaseController
 * @package app\index\controller
 * @description:前台首页
 * @time:2018年6月10日00:16:43
 * @Author: yfl
 * @QQ 554665488
 */
class BaseController extends Controller
{
    protected $head = [];

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
}