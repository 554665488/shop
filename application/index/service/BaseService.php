<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:22
 */

namespace app\index\service;

use SC;

class BaseService
{
    protected $userInfo;

    public function __construct()
    {

    }

    public function init()
    {
        $user = SC::getUserInfoSession('index');
        if (!empty($user)) {
            $this->userInfo = $user;
        }
    }

}