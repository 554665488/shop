<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:16
 */

namespace app\model;


class PlatformAdvPosition extends Base
{
    protected $pk = 'ap_id';

    //关联广告的具体信息
    public function paltformAdv()
    {
          return $this->hasOne('PaltformAdv','adv_id','ap_id');
    }
}