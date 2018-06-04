<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-26
 * Time: 21:44
 */

namespace app\admin\controller;

use Service;
use app\admin\service\GoodsService;

use think\facade\Lang;
use think\facade\Request;
use  UploadUtil;

/**
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Class GoodsController
 * @package app\admin\controller
 */
class GoodsController extends BaseController
{
    private $goodService;

    public function initialize()
    {
        parent::initialize();

        $this->goodService = new  GoodsService();
    }

    /**
     * @description查询商品分类:
     * @time:2018年5月26日22:23:22
     * @Author: yfl
     * @QQ 554665488
     */
    public function goodslist(Request $request)
    {
        $this->setTitle(Lang::get('goods_list_title'));
        if (Request::isPost()) {
            $where = [
                'start_date' => !empty($request::param('start_date')) ? ['> time', $request::param('start_date')] : '',
                'end_date' => !empty($request::param('end_date')) ? ['< time', $request::param('end_date')] : '',
                'goods_name' => !empty($request::param('goods_name')) ? ['like', '%' . $request::param('goods_name') . '%'] : '',
                'category_id_1' => $request::param('category_id_1', ''),
                'category_id_2' => $request::param('category_id_2', ''),
                'category_id_3' => $request::param('category_id_3', ''),
            ];
            $getGoodsList = $this->goodService->getGoodsList($request::param('page', 1), $request::param('limit', 10), $where);
            $getGoodsCount = $this->goodService->getGoodsCount();

            return $this->returnLayuiPageData($getGoodsList, $getGoodsCount);
        }

        $getAllGoodsCategory = $this->goodService->getGoodsCategoryAjax();
//        $this->assign('goodsCateGoryJson', json_encode($getAllGoodsCategory, JSON_UNESCAPED_UNICODE));
        $this->assign('goodsCateGoryList', $getAllGoodsCategory);
        return $this->fetch();
    }

    /**
     * @description:获取联动分类
     * @time: 2018年6月3日02:30:35
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     */
    public function getGoodsCategoryAjax(Request $request)
    {
        if ($request::isGet()) {
            $category_id = $request::param('category_id', 0);
            $array = $this->goodService->getGoodsCategoryAjax($category_id);
            $html = '';
//            halt($array);
            if (!empty($array)) {
                foreach ($array as $index => $item) {
                    $html .= "<option value='" . $item['category_id'] . "'>" . $item['category_name'] . "</option>";
                }
            }
            echo $html;
            exit;
        }
    }

    //商品分类
    public function getcategorybyparentajax()
    {

    }

    //商品添加
    public function addGoods(Request $request)
    {
        $this->setTitle(Lang::get('goods_add_title'));
        if ($request::isPost()) {

        }
        $getAllGoodsCategory = $this->goodService->getGoodsCategoryAjax();
        $this->assign('goodsCateGoryList', $getAllGoodsCategory);
        return $this->fetch();
    }

    /**
     * @description:软删除数据
     * @time: 2018年6月3日11:45:06
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return \think\response\Json
     */
    public function delGoods(Request $request)
    {
        if ($request::isPost() || $request::isGet()) {
            $goods_ids = $request::param();

            if (isset($goods_ids['goods_ids']) && !empty($goods_ids['goods_ids'])) {
                $res = $this->goodService->delGoods($goods_ids['goods_ids'], false);
                if ($res) {
                    return self::delAjaxReturnSuccess();
                } else {
                    return self::delAjaxReturnFail();
                }
            } else {
                return self::delAjaxReturnFail('删除异常');
            }
        }
    }

    /**
     * @description:上下架
     * @time: 2018年6月2日11:08:19
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return \think\response\Json
     */
    public function modifyGoodsOnline(Request $request)
    {
        $condition = $request::param('goods_ids');
        $status = $request::param('status');
        $result = $this->goodService->modifyGoodsOnline($condition, $status);
        return json($result);
    }

    public function updateQrcode()
    {

    }

    /**
     * @description:ajax异步上传图片
     * @time:2018年6月4日00:11:46
     * @Author: yfl
     * @QQ 554665488
     */
    public function uploadGoodsImg()
    {
        UploadUtil::setSavePath('/goods_img');
        $res = UploadUtil::uploadOne();
        $pic_id=$this->goodService->GoodsImgSaveAlbumPicture($res);
        echo $pic_id;
    }
}