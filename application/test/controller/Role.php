<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-19
 * Time: 11:47
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\test\controller;


use app\model\Admin;
use think\Controller;

class Role extends Controller
{
    public function index()
    {
        $obj = Admin::get(3);
        foreach ($obj->adminRoles as $index => $adminRole) {
          dump($adminRole);
      }
    }
}