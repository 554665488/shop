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

use app\admin\validate\addGoodsValidate;
use app\model\AlbumPicture;
use app\model\Goods;
use app\model\GoodsCategory;
use QRcodeUtil;
use Table;
use think\db\Query;
use think\facade\Request;
use Tree;

class GoodsService extends BaseService
{
    /**
     * @description:查询所有的商品分类格式化后返回
     * @time:2018年6月4日16:33:17
     * @Author: yfl
     * @QQ 554665488
     * @return mixed
     * @throws \think\exception\DbException
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

        foreach ($where as $index => $item) {
            if ($item == '') {
                unset($where[$index]);
            }
        }
        return Goods::where($where)->with(['albumPicture' => function (Query $query) {
            $query->field('pic_id,pic_cover_small');
        }])->field('goods_id,goods_name,market_price,QRcode,picture,price,stock,real_sales,state,sort')->limit(($page_index - 1) * $page_size, $page_size)->order('goods_id desc')->select();
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
            'update_time' => date('Y-m-d H:i:s'),
            'sale_date' => date('Y-m-d H:i:s'),//上下架时间
        ];
        $where = "goods_id in ($condition)";
        $result = Table::updateTable('goods', $where, $data);

        if ($result) {
            return ajaxReturn(true, '下架成功');
        } else {
            return ajaxReturn(false, '下架失败');
        }
    }

    /**
     * @description:更新商品二维码 删除原来二维码
     * @time: 2018-6-8 02:15:48
     * @Author: yfl
     * @QQ 554665488
     * @param $goodIds
     * @return array
     * @throws \Exception
     */
    public function updateGoodsQrcode($goodIds)
    {
        //处理一个商品
        if (strpos($goodIds, ',') === false) {
            //先删除原来的二维码文件
            $delFilePath = Table::getTableField('goods', "goods_id = {$goodIds}", 'QRcode', true);
            if (!empty($delFilePath)) {
                $delFileRealPath = PROJECT_ROOT . '/public' . $delFilePath['QRcode'];
                if (delFile($delFileRealPath) === false) {
                    return ajaxReturn(false, '删除旧的二维码失败');
                }
            }


            $QrcodeUrl = DOMAIN_NAME_VISIT . WAP_MODEL . '/goods/goodsDetail/goods_id/' . $goodIds;
            $file = QRcodeUtil::make($QrcodeUrl, 'goods_qrcode_' . $goodIds . '_');//生成二维码
            //模型支持调用数据库的方法直接更新数据  //数据库的update方法返回影响的记录数
            $res = Table::updateTable('goods', "goods_id = {$goodIds}", ['QRcode' => '/' . $file]);
            if (!$res) {
                return ajaxReturn(false, '更新二维码失败');
            } else {
                return ajaxReturn(true, '更新二维码成功');
            }
        } else {
            //处理多个商品
            $data = [];
            //先删除原来的二维码文件
            $delFilePathArr = Table::getTableField('goods', "goods_id in ({$goodIds})", 'QRcode');
            if (!empty($delFilePathArr)) {
                foreach ($delFilePathArr as $index => $item) {
                    $delFileRealPath = PROJECT_ROOT . '/public' . $item['QRcode'];

                    if (delFile($delFileRealPath) === false) {
                        return ajaxReturn(false, '删除旧的二维码失败');
                    }
                }
            }

            $goodIdsArr = explode(',', $goodIds);
            foreach ($goodIdsArr as $index => $item) {//批量生成二维码
                $QrcodeUrl = DOMAIN_NAME_VISIT . WAP_MODEL . '/goods/goodsDetail/goods_id/' . $item;
                $data[] = ['goods_id' => $item, 'QRcode' => '/' . QRcodeUtil::make($QrcodeUrl, 'goods_qrcode_' . $item . '_')];
            }
            $goodsModel = new Goods;
            $res = $goodsModel->saveAll($data);
            if (!$res) {
                return ajaxReturn(false, '更新二维码失败');
            } else {
                return ajaxReturn(true, '更新二维码成功');
            }
        }
    }

    /**
     * @description:软删除商品
     * @time:  2018年6月2日18:08:033
     * @Author: yfl
     * @QQ 554665488
     * @param $goods_ids
     * @param bool $flog :是否真正的删除
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
     * @description:添加商品 使用验证器验证数据
     * @time:2018年6月11日23:00:10
     * @Author: yfl
     * @QQ 554665488
     * @param $addGoodsParams
     * @return array
     */
    public function addGoods($addGoodsParams)
    {
        $data = [
            'goods_name' => $addGoodsParams['goods_name'],//1
            'category_id_1' => $addGoodsParams['category_id_1'],//1
            'category_id_2' => $addGoodsParams['category_id_2'],//1
            'category_id_3' => $addGoodsParams['category_id_3'],//1
            'shop_id' => isset($addGoodsParams['shop_id']) ? $addGoodsParams['shop_id'] : 0,//0平台商品
            'introduction' => $addGoodsParams['introduction'],//商品简介，促销语 1
            'keywords' => $addGoodsParams['keywords'],//1
            'supplier_id' => $addGoodsParams['supplier_id'],//1  TODO 供货商 下拉框要从数据库里拿
            'market_price' => $addGoodsParams['market_price'],//市场价 1
            'price' => $addGoodsParams['price'],//销售价 1
            'promotion_price' => $addGoodsParams['promotion_price'],//商品促销价格
            'cost_price' => $addGoodsParams['cost_price'],//成本价1
            'base_sales' => $addGoodsParams['base_sales'],//基础销量1
            'base_clicks' => $addGoodsParams['base_clicks'],//基础点击数1
            'shares' => $addGoodsParams['shares'],//基础分享数1
            'code' => $addGoodsParams['code'],//商家编码1
            'stock' => $addGoodsParams['stock'],//总库存1
            'min_stock_alarm' => $addGoodsParams['min_stock_alarm'],//库存预警值1
            'goods_attribute_id' => $addGoodsParams['goods_attribute_id'],//1 TODO 商品类型 下拉框要从数据库里拿
            'picture' => isset($addGoodsParams['album_picture_id']) ? $addGoodsParams['album_picture_id'][0] : '',//2 TODO 商品主图 商品图片保存id
            'img_id_array' => isset($addGoodsParams['album_picture_id']) ? implode(',', $addGoodsParams['album_picture_id']) : '',//2 商品图片序列  100,200,201 逗号分开
            'brand_id' => $addGoodsParams['brand_id'],//1 TODO 商品品牌下拉框要从数据库里拿
            'description' => htmlentities($addGoodsParams['description']),//商品详情内容 1
            'province_id' => $addGoodsParams['province_id'],// 商品物流信息 一级地区id 下拉框要从数据库里拿 1
            'city_id' => $addGoodsParams['city_id'],// 商品物流信息 二级地区id ajax下拉框要从数据库里拿 1
            'shipping_fee' => $addGoodsParams['shipping_fee'],// 运费 0为免运费 1
            'shipping_fee_type' => $addGoodsParams['shipping_fee_type'],// '计价方式1.重量2.体积3.计件',
            'goods_weight' => $addGoodsParams['goods_weight'],// 商品重量 1
            'goods_volume' => $addGoodsParams['goods_volume'],// 商品体积 1
            'is_stock_visible' => $addGoodsParams['is_stock_visible'],// 页面是否显示库存 1
            'point_exchange_type' => $addGoodsParams['point_exchange_type'],// '积分兑换类型 0 非积分兑换 1 只能积分兑换 ', 1
//                'point_exchange' => $addGoodsParams['point_exchange'],// 积分兑换 TODO 使用了ajax 2
            'give_point' => $addGoodsParams['give_point'],// 购买商品赠送积分 1
            'max_buy' => $addGoodsParams['max_buy'],// 每人限购(0不限购) 1
            'shelves' => $addGoodsParams['shelves'],//1立即上架2放入仓库 1
            'sort' => $addGoodsParams['sort'] ?? 0,//排序 2
        ];
        $validate = new addGoodsValidate();
        if (!$validate->check($data)) {
            return ajaxReturn('validate', $validate->getError());
        }
        $res = Goods::create($data);
        if (is_object($res)) {
            return ajaxReturn(true, '添加商品成功');
        } else {
            return ajaxReturn(false, '添加商品失败');
        }
    }

    /**
     * @description:获得编辑商品的信息
     * @time:2018-6-12 16:40:13
     * @Author: yfl
     * @QQ 554665488
     * @param $goods_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getEditGoods($goods_id)
    {
        $goods = Goods::where('goods_id=' . $goods_id)
            ->with('goodsSku,shop,albumPicture,category_1,category_2,category_3')->find()->toArray();
        return $goods;
    }

    /**
     * @description:编辑更新
     * @time:2018年6月12日16:46:47
     * @Author: yfl
     * @QQ 554665488
     * @param $updateGoodsParams
     * @return array
     */
    public function editResSave($updateGoodsParams)
    {
        $data = [
            'goods_id' => $updateGoodsParams['goods_id'],//1
            'goods_name' => $updateGoodsParams['goods_name'],//1
            'category_id_1' => $updateGoodsParams['category_id_1'],//1
            'category_id_2' => $updateGoodsParams['category_id_2'],//1
            'category_id_3' => $updateGoodsParams['category_id_3'],//1
            'shop_id' => isset($updateGoodsParams['shop_id']) ? $updateGoodsParams['shop_id'] : 0,//0平台商品
            'introduction' => $updateGoodsParams['introduction'],//商品简介，促销语 1
            'keywords' => $updateGoodsParams['keywords'],//1
            'supplier_id' => $updateGoodsParams['supplier_id'],//1  TODO 供货商 下拉框要从数据库里拿
            'market_price' => $updateGoodsParams['market_price'],//市场价 1
            'price' => $updateGoodsParams['price'],//销售价 1
            'promotion_price' => $updateGoodsParams['promotion_price'],//商品促销价格
            'cost_price' => $updateGoodsParams['cost_price'],//成本价1
            'base_sales' => $updateGoodsParams['base_sales'],//基础销量1
            'base_clicks' => $updateGoodsParams['base_clicks'],//基础点击数1
            'shares' => $updateGoodsParams['shares'],//基础分享数1
            'code' => $updateGoodsParams['code'],//商家编码1
            'stock' => $updateGoodsParams['stock'],//总库存1
            'min_stock_alarm' => $updateGoodsParams['min_stock_alarm'],//库存预警值1
            'goods_attribute_id' => $updateGoodsParams['goods_attribute_id'],//1 TODO 商品类型 下拉框要从数据库里拿
            'picture' => isset($updateGoodsParams['album_picture_id']) ? $updateGoodsParams['album_picture_id'][0] : '',//2 TODO 商品主图 商品图片保存id
            'img_id_array' => isset($updateGoodsParams['album_picture_id']) ? implode(',', $updateGoodsParams['album_picture_id']) : '',//2 商品图片序列  100,200,201 逗号分开
            'brand_id' => $updateGoodsParams['brand_id'],//1 TODO 商品品牌下拉框要从数据库里拿
//            'description' =>$updateGoodsParams['description']?? htmlentities($updateGoodsParams['description']),//商品详情内容 1
            'province_id' => $updateGoodsParams['province_id'],// 商品物流信息 一级地区id 下拉框要从数据库里拿 1
            'city_id' => $updateGoodsParams['city_id'],// 商品物流信息 二级地区id ajax下拉框要从数据库里拿 1
            'shipping_fee' => $updateGoodsParams['shipping_fee'],// 运费 0为免运费 1
            'shipping_fee_type' => $updateGoodsParams['shipping_fee_type'],// '计价方式1.重量2.体积3.计件',
            'goods_weight' => $updateGoodsParams['goods_weight'],// 商品重量 1
            'goods_volume' => $updateGoodsParams['goods_volume'],// 商品体积 1
            'is_stock_visible' => $updateGoodsParams['is_stock_visible'],// 页面是否显示库存 1
            'point_exchange_type' => $updateGoodsParams['point_exchange_type'],// '积分兑换类型 0 非积分兑换 1 只能积分兑换 ', 1
//                'point_exchange' => $addGoodsParams['point_exchange'],// 积分兑换 TODO 使用了ajax 2
            'give_point' => $updateGoodsParams['give_point'],// 购买商品赠送积分 1
            'max_buy' => $updateGoodsParams['max_buy'],// 每人限购(0不限购) 1
            'shelves' => $updateGoodsParams['shelves'],//1立即上架2放入仓库 1
            'sort' => $updateGoodsParams['sort'] ?? 0,//排序 2
        ];
        $res = Goods::update($data);
        if (is_object($res)) {
            return ajaxReturn(true, '更新成功');
        } else {
            return ajaxReturn(false, '更新失败');
        }
    }

    /**
     * @description: 再一次添加商品图片
     * @time:2018年6月15日00:37:223
     * @Author: yfl
     * @QQ 554665488
     * @param $goods_id:商品的id
     * @param $newAlbumPicId:相册的主键ID
     * @return array
     * @throws \think\exception\DbException
     */
    public function againAddGoodsImgService($goods_id, $newAlbumPicId)
    {
        $goodsObj = Goods::get($goods_id);
        $goodsObj->img_id_array = $goodsObj->img_id_array . ','.$newAlbumPicId;
//        dump($goodsObj->img_id_array . ','.$newAlbumPicId);
        if ($goodsObj->save()) {
            return ajaxReturn(true, '添加成功');
        } else {
            return ajaxReturn(false, '添加失败');
        }
    }
}