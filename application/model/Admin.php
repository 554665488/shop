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
}