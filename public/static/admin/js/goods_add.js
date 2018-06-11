/**
 * Created by 554665488 on 2018-6-2.
 */

layui.use(['laypage', 'layedit', 'ajaxRequest', 'form', 'laydate'], function () {
    var laypage = layui.laypage
        , layedit = layui.layedit, ajaxRequest = layui.ajaxRequest, form = layui.form, laydate = layui.laydate;
    form.render();
    //日期
    // laydate.render({
    //     elem: '#startTime'
    // });
    // laydate.render({
    //     elem: '#endTime'
    // });

    //提交数据使用layui的监听submit提交开始
    form.on('submit(addGoods)', function(data){
        // console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
        var url=urlConfig.goods.addGoods;
        ajaxRequest.ajaxRequest(url,data.field,'json','post');
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
    //提交数据使用layui的监听submit提交结束
});
//商品分类开始
layui.use(['form', 'ajaxRequest'], function () {
    var form = layui.form, ajaxRequest = layui.ajaxRequest;
    form.on('select(js-category-one)', function (data) {
        var category_one_value = data.value, that = $('.js-category-two');
        // console.log(category_one_value.length);
        if (category_one_value.length == 0) {
            console.log('没有选择一级分类');
            that.empty();
            $('.js-category-three').empty();
            form.render();
            return false;
        }
        var url = urlConfig.goods.getGoodsCategoryAjax + category_one_value;
        ajaxRequest.loadTableHtml(that, url);
        $('.js-category-three').empty();
    });
    //下
    form.on('select(js-category-two)', function (data) {
        var category_two_value = data.value, that = $('.js-category-three');
        console.log(category_two_value);
        var url = urlConfig.goods.getGoodsCategoryAjax + category_two_value;
        ajaxRequest.loadTableHtml(that, url);
    });
    form.render();
});
//商品分类结束
//添加商品数据验证  TODO 后期要补全
layui.use(['form', 'validator'], function () {
    var form = layui.form, validator = layui.validator;
    form.verify({
        goods_name: function (value, item) { //value：表单的值、item：表单的DOM对象
            if (value.length>60) {
                return '不能超过60个字';
            }
        },
        introduction: function (value, item) {
            if (value.length>60) {
                return '不能超过60个字';
            }
        },
        keywords: function (value, item) {
            if (value.length>40) {
                return '不能超过40个字';
            }
        },
        supplier_id: function (value, item) {
            if (!validator.IsInteger(value)) {
                return '请选择供货商';
            }
        },
        aa: function (value, item) {},
         pass: [
            /^[\S]{6,12}$/
            , '密码必须6到12位，且不能出现空格'
        ]
    });
});


// 文件上传使用百度的web_upload







//商品分类结束
/**
 * 添加扩展分类
 */
// function addExtentCategoryBox(){
//     var extent_sort=0;
//     var html = '<div class="extend-name-category" id="extend_name_category'+extent_sort+'" data-flag="extend_category" data-goods-id="0" cid="" data-attr-id="" cname="">';
//     html += '<span class="category-text"onclick="editCategory(this);"></span>';
//     html += '&nbsp;&nbsp;<span class="do-style" onclick="editCategory(this);"><i class="fa fa-edit"></i>&nbsp;编辑</span>&nbsp;&nbsp;';
//     html += '<span class="do-style" onclick="removeParentBox(this);"><i class="fa fa-trash-o"></i>&nbsp;删除</span>';
//     html += '<span class="help-inline" style="vertical-align: top;">已添加的商品扩展分类不能为空</span>';
//     $(".extend-name-category-box").append(html);
//     extent_sort++;
// }