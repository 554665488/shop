/**
 * Created by 554665488 on 2018-6-3.
 */
/**
 * 后台请求的地址配置
 * @type {{getGoodsCategoryAjax: string, modifyGoodsOnline: string, delGoods: string}}
 */
var urlConfig = {
    'index': {
       'login':'/admin/login',//登录
    },
    'goods': {
        'goodslist': '/admin/goodslist',//商品列表
        'getGoodsCategoryAjax': '/admin/goods/getGoodsCategoryAjax/category_id/',  //获取商品分类 get
        'modifyGoodsOnline': '/admin/goods/modifyGoodsOnline',  //上下架  get
        'delGoods': '/admin/goods/delGoods',  //删除商品 get / post
        'uploadGoodsImg': '/admin/goods/uploadGoodsImg',  //上传商品图片
        'updateQrcode':'/admin/goods/updateQrcode', //更新二维码支持批量更新
    }
};