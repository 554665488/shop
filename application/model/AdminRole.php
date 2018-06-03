<?php
namespace app\model;

use think\Model;

//角色表
class AdminRole extends Model
{
   //指定权限的id字段名
    protected $pk = "role_id";
}