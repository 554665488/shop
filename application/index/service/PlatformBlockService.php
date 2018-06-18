<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-15
 * Time: 18:51
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\index\service;
use app\model\PlatformBlock;

/**
 * Class PlatformBlockService
 * @package app\index\service
 * @description:首页促销模块业务
 * @time:2018年6月15日18:52:29
 * @Author: yfl
 * @QQ 554665488
 */
class PlatformBlockService extends BaseService
{
    /**
     * 广告的详细信息
     */
    public function getPlatformBlockDetailed()
    {
        return PlatformBlock::with('goodsCategory_1_1,goodsCategory_1_2,goodsCategory_1_3,apImage,apSlide,apImages')->select();
    }
}