<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-11
 * Time: 15:36
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\admin\validate;


use think\Validate;

/**
 * Class addGoodsValidate
 * @package app\admin\validate
 * @description:添加商品验证器
 * @time:2018年6月11日15:37:52
 * @Author: yfl
 * @QQ 554665488
 */
class addGoodsValidate extends Validate
{
    public function aaa()
    {
        $addGoodsParams = [];
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
            'promotion_price' => $addGoodsParams['promotion_price'],//销售价 1
            'cost_price' => $addGoodsParams['cost_price'],//成本价1
            'base_sales' => $addGoodsParams['base_sales'],//基础销量1
            'base_clicks' => $addGoodsParams['base_clicks'],//基础点击数1
            'shares' => $addGoodsParams['shares'],//基础分享数1
            'code' => $addGoodsParams['code'],//商家编码1
            'stock' => $addGoodsParams['stock'],//总库存1
            'min_stock_alarm' => $addGoodsParams['min_stock_alarm'],//库存预警值1
            'goods_attribute_id' => $addGoodsParams['goods_attribute_id'],//1 TODO 商品类型 下拉框要从数据库里拿
            'picture' => $addGoodsParams['album_picture_id'][0],//2 TODO 商品主图 商品图片保存id
            'img_id_array' => implode(',', $addGoodsParams['album_picture_id']),//2 商品图片序列  100,200,201 逗号分开
            'brand_id' => $addGoodsParams['brand_id'],//1 TODO 商品品牌下拉框要从数据库里拿
            'description' => $addGoodsParams['description'],//商品详情内容 1
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
    }

    protected $rule = [
        'goods_name' => ['require', 'length' => '10,60', 'chsAlphaNum'],
        'category_id_1' => ['require', 'number'],
        'category_id_2' => ['require', 'number'],
        'category_id_3' => ['require', 'number'],
        'shop_id' => ['require', 'number'],
        'introduction' => ['length' => '10,60', 'chsAlphaNum'],
        'keywords' => ['length' => '10,40', 'chsAlphaNum'],
        'supplier_id' => ['number'],
        'market_price' => ['number', 'gt' => 0, 'between' => '1,99999999'],
        'cost_price' => ['number', 'gt' => 0, 'between' => '1,99999999'],
        'promotion_price' => ['require', 'number', 'gt' => 0, 'between' => '1,99999999'],
        'base_sales' => ['number', 'gt' => 0, 'between' => '1,99999999'],
        'base_clicks' => ['number', 'gt' => 0, 'between' => '1,99999999'],
        'shares' => ['number', 'gt' => 0, 'between' => '1,99999999'],
        'code' => ['alphaDash'],
        'stock' => ['require', 'number', 'gt' => 0, 'between' => '1,99999999'],
        'min_stock_alarm' => ['require', 'number', 'gt' => 0, 'between' => '1,99999999'],
        'goods_attribute_id' => ['number'],
        'picture' => ['number'],
        'img_id_array' => ['checkImgCount' => 5],
        'brand_id' => ['number'],
        'province_id' => ['number'],
        'city_id' => ['number'],
        'shipping_fee' => ['require','number'],
        'shipping_fee_type' => ['require','number'],
        'goods_weight' => ['require', 'number', 'gt' => 0, 'between' => '1,99999999'],
        'goods_volume' => ['require', 'number', 'gt' => 0, 'between' => '1,99999999'],
        'is_stock_visible' => ['require','number'],
        'point_exchange_type' => ['require','number'],
        'give_point' => ['require','number','between' => '0,99999999'],
        'max_buy' => ['require','number','between' => '0,99999999'],
        'shelves' => ['require','number','between' => '0,2'],
//        'description' => ['number'],
    ];

    protected $message = [
        'goods_name' => [
            'require' => 'goods_name@商品名称必须',
            'length' => 'goods_name@名称只能在10-60之间',
            'chsAlphaNum' => 'goods_name@汉字、字母和数字',
        ],
        'category_id_1' => [
            'require' => 'category_id_1@一级分类必须',
            'number' => 'category_id_1@一级分类必须是数字',
        ],
        'category_id_2' => [
            'require' => 'category_id_2@二级分类必须',
            'number' => 'category_id_2@二级分类必须是数字',
        ],
        'category_id_3' => [
            'require' => 'category_id_3@三级分类必须',
            'number' => 'category_id_3@三级分类必须是数字',
        ],
        'shop_id' => [
            'require' => 'shop_id@店铺ID必须',
            'number' => 'shop_id@店铺ID必须是数字',
        ],
        'introduction' => [
            'length' => 'introduction@商品促销语只能在10-60之间',
            'chsAlphaNum' => 'introduction@商品促销语汉字、字母和数字',
        ],
        'keywords' => [
            'length' => 'keywords@关键词只能在10-40之间',
            'chsAlphaNum' => 'keywords@关键词汉字、字母和数字',
        ],
        'supplier_id' => [
            'number' => 'supplier_id@供货商不正确',
        ],
        'market_price' => [
            'number' => 'market_price@市场价必须是数字',
            'gt' => 'market_price@市场价必须是大于0',
            'between' => 'market_price@市场价必须是1,99999999之间'
        ],
        'cost_price' => [
            'number' => 'cost_price@成本价必须是数字',
            'gt' => 'cost_price@成本价必须是大于0',
            'between' => 'cost_price@成本价必须是1,99999999之间'
        ],
        'base_sales' => [
            'number' => 'base_sales@基础销量必须是数字',
            'gt' => 'base_sales@基础销量必须是大于0',
            'between' => 'base_sales@基础销量必须是1,99999999之间'
        ],
        'base_clicks' => [
            'number' => 'base_clicks@基础点击数必须是数字',
            'gt' => 'base_clicks@基础点击数必须是大于0',
            'between' => 'base_clicks@基础点击数必须是1,99999999之间'
        ],
        'shares' => [
            'number' => 'shares@基础分享数必须是数字',
            'gt' => 'shares@基础分享数必须是大于0',
            'between' => 'shares@基础分享数必须是1,99999999之间'
        ],
        'promotion_price' => [
            'require' => 'promotion_price@销售价必须',
            'number' => 'promotion_price@销售价必须是数字',
            'gt' => 'promotion_price@销售价必须是大于0',
            'between' => 'promotion_price@销售价必须是1,99999999之间'
        ],
        'code' => [
            'alphaDash' => 'code@只能为字母和数字，下划线_及破折号-'
        ],
        'stock' => [
            'require' => 'stock@总库存必须',
            'number' => 'stock@总库存必须是数字',
            'gt' => 'stock@总库存必须是大于0',
            'between' => 'stock@总库存必须是1,99999999之间'
        ],
        'min_stock_alarm' => [
            'require' => 'min_stock_alarm@库存预警必须',
            'number' => 'min_stock_alarm@库存预警必须是数字',
            'gt' => 'min_stock_alarm@库存预警必须是大于0',
            'between' => 'min_stock_alarm@库存预警必须是1,99999999之间'
        ],
        'goods_attribute_id' => [
            'number' => 'goods_attribute_id@商品类型不正确'
        ],
        'picture' => [
            'number' => 'picture@商品主图类型不正确'
        ],
        'brand_id' => [
            'number' => 'brand_id@商品品牌类型不正确'
        ],
        'province_id' => [
            'number' => 'province_id@所在地省份不正确'
        ],
        'city_id' => [
            'number' => 'city_id@所在地市不正确'
        ],
        'shipping_fee' => [
            'require' => 'shipping_fee@运费类型必须',
            'number' => 'shipping_fee@店运费类型不正确',
        ],
        'shipping_fee_type' => [
            'require' => 'shipping_fee_type@计价方式类型必须',
            'number' => 'shipping_fee_type@计价方式类型不正确',
        ],
        'goods_weight' => [
            'require' => 'goods_weight@商品重量必须',
            'number' => 'goods_weight@商品重量必须是数字',
            'gt' => 'goods_weight@商品重量必须是大于0',
            'between' => 'goods_weight@商品重量必须是1,99999999之间'
        ],
        'goods_volume' => [
            'require' => 'goods_volume@商品体积必须',
            'number' => 'goods_volume@商品体积必须是数字',
            'gt' => 'goods_volume@商品体积必须是大于0',
            'between' => 'goods_volume@商品体积必须是1,99999999之间'
        ],
        'is_stock_visible' => [
            'require' => 'is_stock_visible@页面是否显示库存必须',
            'number' => 'is_stock_visible@页面是否显示库存类型不正确',
        ],
        'point_exchange_type' => [
            'require' => 'point_exchange_type@积分设置必须',
            'number' => 'point_exchange_type@积分设置类型不正确',
        ],
        'give_point' => [
            'require' => 'give_point@购买可赠送设置必须',
            'number' => 'give_point@购买可赠送必须是数字',
            'between' => 'give_point@商品体积必须是0,99999999之间'
        ],
        'max_buy' => [
            'require' => 'max_buy@每人限购设置必须',
            'number' => 'max_buy@每人限购必须是数字',
            'between' => 'max_buy@每人限购必须是0,99999999之间'
        ],
        'shelves' => [
            'require' => 'shelves@是否上架设置必须',
            'number' => 'shelves@是否上架必须是数字',
            'between' => 'shelves@是否上架必须是0,2之间'
        ],
    ];

    /**
     * @description:验证上传图片的数量
     * @time:2018年6月11日16:56:04
     * @Author: yfl
     * @QQ 554665488
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool|string
     */
    protected function checkImgCount($value, $rule, $data = [])
    {
        if (strpos($value, ',') === false) {
            return true;
        } else {
            $imgArr = explode(',', $value);
            if (count($imgArr) > $rule) {
                return '最多上传' . $rule . '张商品图片';
            }
        }
        return true;
    }
}