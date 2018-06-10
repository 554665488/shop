<?php
namespace app\model;

use think\Model;

/**
 * Class AdminRole
 * @package app\model
 * @description:角色表
 * @time:
 * @Author: yfl
 * @QQ 554665488
 */
class AdminRole extends Model
{
   //指定权限的id字段名
    protected $pk = "role_id";
}