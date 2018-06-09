<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-26
 * Time: 21:35
 */

namespace app\admin\service;

use app\model\AlbumPicture;
use app\model\Goods;
use app\model\GoodsCategory;
use Tree;
use Table;

class GoodsService extends BaseService
{
    /**
     * @description:查询所有的商品分类格式化后返回
     * @time: 2018年5月27日01:19:53
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     */
    public function getAllGoodsCategory()
    {
        return Tree::recursiveMakeTree(GoodsCategory::all(), 'category_id');
    }

    /**
     * @description:ajax获得联动菜单
     * @time: 2018年6月3日02:22:59
     * @Author: yfl
     * @QQ 554665488
     * @param string $category_id
     * @param string $field
     * @return mixed
     */
    public function getGoodsCategoryAjax($category_id = '', $field = '*')
    {
        if ($category_id == '') {
            $where = 'pid = 0';
        } else {
            $where = 'pid = ' . $category_id;
        }
        return Table::getTableField('goods_category', $where, $field);
    }

    /**
     * @description:获得商品列表
     * @time: 2018年5月29日21:43:19
     * @Author: yfl
     * @QQ 554665488
     * @param $page_index
     * @param $page_size
     * @param array $where
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsList($page_index, $page_size, array $where)
    {

//        return Goods::with('shop,category_1,category_2,category_3')->select();
        foreach ($where as $index => $item) {
            if ($item == '') {
                unset($where[$index]);
            }
        }
        return Goods::where($where)->limit(($page_index - 1) * $page_size, $page_size)->select();
    }

    /**
     * @description:获得商品的数量
     * @time:
     * @Author: yfl
     * @QQ 554665488
     * @return false|static[]
     */
    public function getGoodsCount()
    {

        return Table::getCount('goods', 'delete_time IS NUll');
    }

    /**
     * @description:上下架业务处理
     * @time: 2018年6月2日17:56:54
     * @Author: yfl
     * @QQ 554665488
     * @param $condition
     * @param int $status
     * @return array
     */
    public function modifyGoodsOnline($condition, $status = 0)
    {
        $data = [
            'state' => $status,
            'update_time' => date('Y-m-d H:i:s')
        ];
        $where = "goods_id in ($condition)";
        $result = Table::updateTable('goods', $where, $data);

        if ($result) {
            return ajaxReturn(true, '下架成功');
        } else {
            return ajaxReturn(false, '下架失败');
        }
    }

    public function updateGoodsQrcode($goodIds)
    {
        if (!isset($goodIds)) {
            return false;
        }
        if (strpos($goodIds, ',') === false) {
            $QrcodeUrl = DOMAIN_NAME_VISIT . WAP_MODEL . '/goods/goodsDetail/goods_id' . $goodIds;
        } else {
            $goodIdsArr = explode(',', $goodIds);
        }
        dump($goodIdsArr);

    }

    /**
     * @description:删除商品
     * @time:  2018年6月2日18:08:033
     * @Author: yfl
     * @QQ 554665488
     * @param $goods_ids
     * @param bool $flog
     * @return int
     */
    public function delGoods($goods_ids, $flog = false)
    {
        if (is_array($goods_ids)) {
            $delWhere = array_values($goods_ids);
            $res = Goods::delGoods($delWhere, $flog);
        } else {

            $res = Goods::delGoods(trim($goods_ids, ','), $flog);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @description:处理上传商品的图片并制作缩略图保存到相册表
     * @time: 2018年6月4日00:00:35
     * @Author: yfl
     * @QQ 554665488
     * @param $imgPath
     * @return bool
     */
    public function GoodsImgSaveAlbumPicture($imgPath)
    {
        $data = [
            'pic_name' => $imgPath['uploadFileInfo']['old_file_name'],//原图名字
            'pic_cover' => '/upload/goods_img/' . $imgPath['uploadFileInfo']['path'],//上传的图片路径
        ];
        $absolutePath = PROJECT_ROOT . '/public' . $data['pic_cover'];//文件的绝对路径用来制作缩略图 TODO
        $data['pic_cover_big'] = $this->makeImgThumb($absolutePath, 700, 700, '/upload/goods_img/');//大图路径;
        $data['pic_size_big'] = '700,700';//大图大小
        $data['pic_cover_mid'] = $this->makeImgThumb($absolutePath, 360, 360, '/upload/goods_img/');//中图路径
        $data['pic_size_mid'] = '360,360';//中图大小
        $data['pic_cover_small'] = $this->makeImgThumb($absolutePath, 240, 240, '/upload/goods_img/');//小图路径
        $data['pic_size_small'] = '240,240';//小图大小
        $data['pic_cover_micro'] = $this->makeImgThumb($absolutePath, 60, 60, '/upload/goods_img/');//微图路径
        $data['pic_size_micro'] = '60,60';//微图大小
        $data['upload_time'] = getDateTime();
        $res = AlbumPicture::create($data);//create方法返回的是当前模型的对象实例
        if ($res) {
            return $res->pic_id;
        } else {
            return false;
        }
    }


}