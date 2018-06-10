<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-5
 * Time: 22:21
 */

namespace app\index\service;


use app\model\CmsArticle;

class CmsService extends BaseService
{
    /**
     * @description:返回文章
     * @time:2018年6月10日01:58:01
     * @Author: yfl
     * @QQ 554665488
     * @param string $where
     * @param int $page_index
     * @param int $page_size
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCmsArticle($where = '1 = 1' ,$page_index=1,$page_size= 10)
    {
        return CmsArticle::where($where)->page($page_index,$page_size)->order('public_time','desc')->select();
    }
}