<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 18:42
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\model;

/**
 * Class Member
 * @package app\model
 * @description:会员表  前台用户表
 * @time:2018年6月15日18:43:013
 * @Author: yfl
 * @QQ 554665488
 */
class Member extends Base
{
    /**
     * 数据表主键id
     *
     * @var string
     */
    protected $pk = "uid";

    public function user()
    {
        return $this->hasOne('User', 'uid', 'uid');
    }

    /**
     * 关联会员级别 一对一
     */
    public function memberLevel()
    {
        return $this->hasOne('MemberLevel', 'level_id', 'member_level');
    }
}