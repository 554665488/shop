<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 19:00
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\model;

/**
 * Class User
 * @package app\model
 * @description:系统用户表
 * @time:2018年6月15日19:03:12
 * @Author: yfl
 * @QQ 554665488
 */
class User extends Base
{
    /**
     * 数据表主键id
     *
     * @var string
     */
    protected $pk = "uid";

    /**
     * @description:关联会员表
     * @time:
     * @Author: yfl
     * @QQ 554665488
     */
    public function member()
    {
        return $this->hasOne('Member', 'uid', 'uid');
    }
}