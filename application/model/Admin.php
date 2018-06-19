<?php

namespace app\model;

use think\Model;


//角色表
class Admin extends Model
{
    //指定权限id字段名
    protected $pk = "admin_id";
//    protected $table = 'tp_admin_user';

    //关联权限
    public function adminRole()
    {
        return $this->hasOne('AdminRole', 'role_id', 'role_id');
    }

    public function adminRoles()
    {
        /**
         * 关联模型（必须）：模型名或者模型类名
         * 中间表：默认规则是当前模型名+_+关联模型名 （可以指定模型名）
         * 外键：中间表的当前模型外键，默认的外键名规则是关联模型名+_id
         * 关联键：中间表的当前模型关联键名，默认规则是当前模型名+_id
         */
        return $this->belongsToMany('AdminRole', '\\app\\model\\AdminAdminRole', 'role_id','admin_id');
    }
}