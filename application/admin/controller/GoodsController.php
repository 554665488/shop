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

use Config;
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
    private $albumPictureService;

    public function initialize()
    {
        parent::initialize();

        $this->goodService = new  GoodsService();
        $this->albumPictureService=\app\common\Service::access(ADMIN_MODEL,'AlbumPictureService');
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
//        $getGoodsList = $this->goodService->getGoodsList($request::param('page', 1), $request::param('limit', 10), $where=[]);
//        halt($getGoodsList);
        if (Request::isPost()) {
            //搜索条件
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
        $this->assign('goodsCateGoryList', $getAllGoodsCategory);
        return $this->fetch();
    }

    /**
     * @description:获取联动分类
     * @time: 2018年6月3日02:30:35
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return \think\response\Json
     */
    public function getGoodsCategoryAjax(Request $request)
    {
        if ($request::isGet()) {
            if ($this->isAjaxHasParam('category_id')) {
                return $this->ajaxReturnFail('请选择分类');
            }
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


    /**
     * @description:商品添加
     * @time:2018年6月11日22:07:51
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return mixed|\think\response\Json   TODO 商铺 shop_id
     */
    public function addGoods(Request $request)
    {
        $this->setTitle(Lang::get('goods_add_title'));
        if ($request::isPost()) {
            $addGoodsParams = $request::param();
            $res = $this->goodService->addGoods($addGoodsParams);

            if ($res['code'] === 'validate') {
                $errorMsg = explode('@', $res['msg']);

                return $this->ajaxReturnFail('数据验证失败', 'validate', ['errorMsg' => ['id' => $errorMsg[0], 'msg' => $errorMsg[1]]]);
            }
            if ($res['code']) {
                return $this->ajaxReturnSuccess($res['msg']);
            } else {
                return $this->ajaxReturnFail($res['msg']);
            }
        }
        $getAllGoodsCategory = $this->goodService->getGoodsCategoryAjax();
        $this->assign('goodsCateGoryList', $getAllGoodsCategory);
        return $this->fetch();
    }

    /**
     * @description:编辑商品 TODO 商品主图没有完善
     * @time:2018年6月13日19:42:15
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function editGoods(Request $request)
    {
        if ($this->isAjaxHasParam('goods_id')) {
            return $this->ajaxReturnFail(Lang::get('isAjaxParam'));
        }
        $goods_id = $request::param('goods_id');
        $this->setTitle(Lang::get('goods_edit_title'));
        if ($request::isPost()) {
            $updateGoodsParams = $request::param();
            $res = $this->goodService->editResSave($updateGoodsParams);
            if ($res['code'] === 'validate') {
                $errorMsg = explode('@', $res['msg']);
                return $this->ajaxReturnFail('数据验证失败', 'validate', ['errorMsg' => ['id' => $errorMsg[0], 'msg' => $errorMsg[1]]]);
            }
            if ($res['code']) {
                return $this->ajaxReturnSuccess($res['msg']);
            } else {
                return $this->ajaxReturnFail($res['msg']);
            }
        }
        $goodsData = $this->goodService->getEditGoods($goods_id);
//halt($goodsData);
        $getAllGoodsCategory = $this->goodService->getGoodsCategoryAjax();
        $goodsData['img_id_array'] = $this->albumPictureService->getGoodsPicture('pic_id in ('.$goodsData['img_id_array'].')','pic_id,pic_cover_mid');//处理上商品和相册关联
        $this->assign([
            'goodsCateGoryList' => $getAllGoodsCategory,//商品三级分类
            'data' => $goodsData,//单件商品信息
        ]);
        return $this->fetch();

    }

    /**
     * @description:软删除商品数据
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
        if ($request::isAjax()) {
            $condition = $request::param('goods_ids');
            $status = $request::param('status');
            $result = $this->goodService->modifyGoodsOnline($condition, $status);
            if ($result['code']) {
                return $this->ajaxReturnSuccess($result['msg']);
            } else {
                return $this->ajaxReturnFail($result['msg']);
            }
        }


    }

    /**
     * @description:更新二维码
     * @time:2018年6月11日02:24:23
     * @Author: yfl
     * @QQ 554665488
     * @param Request $request
     * @return \think\response\Json
     */
    public function updateQrcode(Request $request)
    {
        if ($request::isAjax()) {
            if ($this->isAjaxHasParam('goods_ids')) {
                return $this->ajaxReturnFail(' 没有选中商品');
            }
        }
        $condition = $request::param('goods_ids');
        $res = $this->goodService->updateGoodsQrcode($condition);
        if ($res['code']) {
            return $this->ajaxReturnSuccess($res['msg']);
        } else {
            return $this->ajaxReturnFail($res['msg']);
        }
    }

    /**
     * @description:ajax异步上传图片添加商品
     * @time:2018年6月4日00:11:46
     * @Author: yfl
     * @QQ 554665488
     */
    public function uploadGoodsImg()
    {
        UploadUtil::setSavePath(Config::get('uploadConfig.goods_img'));
        $res = UploadUtil::uploadOne();
        $pic_id = $this->albumPictureService->GoodsImgSaveAlbumPicture($res);
        return $this->ajaxReturnSuccess('上传成功', true, ['album_picture_id' => $pic_id]);
    }
}