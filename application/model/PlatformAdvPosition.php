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

/**
 * Class PlatformAdvPosition
 * @package app\model
 * @description: 平台 广告位表
 * @time:2018年6月10日15:07:12
 * @Author: yfl
 * @QQ 554665488
 */
class PlatformAdvPosition extends Base
{
    protected $pk = 'ap_id';

    //关联广告的具体信息
    public function platformAdv()
    {
          return $this->hasOne('PlatformAdv','ap_id','ap_id');
    }
}