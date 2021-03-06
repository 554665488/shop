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
        'editGoods': '/admin/goods/editGoods',  //编辑商品  post
        'modifyGoodsImg': '/admin/goods/modifyGoodsImg',  //修改图片
        'againAddGoodsImg': '/admin/goods/againAddGoodsImg',  //再次重新上传图片
        'uploadGoodsImg': '/admin/goods/uploadGoodsImg',  //上传商品图片
        'updateQrcode':'/admin/goods/updateQrcode', //更新二维码支持批量更新
        'addGoods':'/admin/goods/addGoods', //添加商品
    },
    'user':{
        'ajaxIsUserExist':'/index/Register/ajaxIsUserExist',//注册检测用户是否存在
        'Register':'/index/Register/register',//手机提交注册
        'sendCode':'/index/Register/sendCode',//发送验证码
        'emailRegister':'/index/Register/emailRegister',//邮箱提交注册
        'login':'/index/Login/login',//邮箱提交注册
    }
};