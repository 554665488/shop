<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 15:52
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\service;
use app\model\PlatformAdvPosition;

/**
 * Class PlatformAdvService
 * @package app\index\service
 * @description:平台广告业务
 * @time:2018年6月15日17:58:32
 * @Author: yfl
 * @QQ 554665488
 */
class PlatformAdvService extends BaseService
{
    /**
     * @description:获得某一个位置的广告内容
     * @time:2018年6月15日18:04:14
     * @Author: yfl
     * @QQ 554665488
     * @param $ap_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPlatformAdvPositionDetailList($ap_id)
    {
        return PlatformAdvPosition::with('platformAdv')->where('ap_id', '=', $ap_id)->select()->toArray();
    }
}