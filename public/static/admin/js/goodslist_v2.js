layui.use(['laypage', 'layedit', 'ajaxRequest', 'form', 'laydate','flow'], function () {
    var laypage = layui.laypage
        , layedit = layui.layedit, ajaxRequest = layui.ajaxRequest, form = layui.form, laydate = layui.laydate,flow = layui.flow;
    form.render();
    //日期
    laydate.render({
        elem: '#startTime'
    });
    laydate.render({
        elem: '#endTime'
    });
    //当你执行这样一个方法时，即对页面中的全部带有lay-src的img元素开启了懒加载（当然你也可以指定相关img）
    flow.lazyimg();
});


//搜索处理开始
layui.use(['form', 'ajaxRequest'], function () {
    var form = layui.form, ajaxRequest = layui.ajaxRequest;
    form.on('select(js-category-one)', function (data) {
        var category_one_value = data.value, that = $('.js-category-two');
        // console.log(category_one_value.length);
        if (category_one_value.length == 0) {
            // console.log('没有选择一级分类');
            that.empty();
            $('.js-category-three').empty();
            form.render();
            return false;
        }
        var url = urlConfig.goods.getGoodsCategoryAjax + category_one_value;
        ajaxRequest.loadTableHtml(that, url);
        $('.js-category-three').empty();
    });
    form.on('select(js-category-two)', function (data) {
        var category_two_value = data.value, that = $('.js-category-three');
        console.log(category_two_value);
        var url = urlConfig.goods.getGoodsCategoryAjax + category_two_value;
        ajaxRequest.loadTableHtml(that, url);
    });
});

//搜索处理结束
layui.use(['table', 'ajaxRequest', 'form', 'laypage'], function () {
    var table = layui.table, form = layui.form, ajaxRequest = layui.ajaxRequest;
    //监听表格复选框选择
    var tableIns = table.render({
        elem: '#goodsListTable'
        // , height: 'full-100'
        , url: urlConfig.goods.goodslist //数据接口
        , page: true //开启分页
        , method: 'post'
        , where: {token: 'sasasas', id: 123}
        , cellMinWidth: 60
        , cols: [[ //表头
            {field: 'goods_id', title: 'ID', sort: true, fixed: 'left', type: 'checkbox'}
            , {field: 'goods_name', title: '商品名称',fixed: 'left'}
            , {title: '商品二维码', templet: '#Qrcode'}
            , {field: 'picture', title: '商品主图', templet: '#picture'}
            , {field: 'price', title: '商品价格', sort: true}
            , {field: 'stock', title: '商品库存'}
            , {field: 'real_sales', title: '销售数量', sort: true}
            , {field: 'state', title: '上架下架', templet: '#modifyGoodsOnlineCheckbox', unresize: true}
            , {field: 'sort', title: '排序', edit: 'text'}
            , {fixed: 'right', title: '操作', align: 'center', toolbar: '#goodsToolbar'}
        ]]
        , limit: 20
        , initSort: {//初始化排序
            field: 'goods_id' //排序字段，对应 cols 设定的各字段名
            , type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
        },
        even: true //开启隔行背景
        , loading: true
        // , id: 'goodsListTableID'//设定容器唯一ID
    });
    //监听上下架操作
    form.on('switch(modifyGoodsOnline)', function (obj) {
        // console.log(this.getAttribute('goods_id'));
        layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
        var url = urlConfig.goods.modifyGoodsOnline;
        if (obj.elem.checked == false) {
            ajaxRequest.ajaxRequest(url, {
                'status': 0,
                'goods_ids': this.getAttribute('goods_id')
            }, 'json', 'get', tableIns);
        } else if (obj.elem.checked == true) {
            ajaxRequest.ajaxRequest(url, {
                'status': 1,
                'goods_ids': this.getAttribute('goods_id')
            }, 'json', 'get', tableIns);
        }

    });
    table.on('checkbox(goodsListTableFilter)', function (obj) {
        console.log(obj.checked); //当前是否选中状态
        console.log(obj.data); //选中行的相关数据
        console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
    });
    table.on('edit(goodsListTableFilter)', function (obj) { //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
        console.log(obj.value); //得到修改后的值
        console.log(obj.field); //当前编辑的字段名
        console.log(obj.data); //所在行的所有相关数据
    });
    table.on('sort(goodsListTableFilter)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        console.log(obj.field); //当前排序的字段名
        console.log(obj.type); //当前排序类型：desc（降序）、asc（升序）、null（空对象，默认排序）
        console.log(this); //当前排序的 th 对象

        //尽管我们的 table 自带排序功能，但并没有请求服务端。
        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
        // table.reload('goodsListTable', {
        //     initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。 layui 2.1.1 新增参数
        //     , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
        //         field: obj.field //排序字段
        //         , order: obj.type //排序方式
        //     }
        // });
    });

    //监听工具条
    table.on('tool(goodsListTableFilter)', function (obj) {
        var data = obj.data;
        if (obj.event === 'edit') {//编辑商品
        // ajaxRequest.getHtml(urlConfig.goods.editGoods,{'goods_id':data.goods_id},'编辑商品',90);
        ajaxRequest.iframeOpen(urlConfig.goods.editGoods,{'goods_id':data.goods_id},'编辑商品',90,100);
            // layer.msg('ID：' + data.id + ' 的查看操作');
            // layer.alert('编辑行：<br>' + JSON.stringify(data))
        } else if (obj.event === 'del') {
            //向服务端发送删除指令
            var url = urlConfig.goods.delGoods;
            ajaxRequest.delData(url, {'goods_ids': data.goods_id}, 'json', 'get', tableIns);
        } else if (obj.event === 'edit') {
            layer.alert('编辑行：<br>' + JSON.stringify(data))
        }
    });
    //批量操作监听处理
    var $ = layui.$, active = {
        CheckDataDel: function () { //批量删除
            var checkStatus = table.checkStatus('goodsListTable')
                , data = checkStatus.data;
            // layer.alert(JSON.stringify(data));
            if (data.length == 0) {
                layer.msg('选中了：' + data.length + ' 个');
                return false;
            }
            //商品软删除
            var goods_ids = new Array();
            $.each(data, function (k, val) {
                goods_ids.push(val.goods_id)
            });
            var url = urlConfig.goods.delGoods;
            ajaxRequest.delData(url, {'goods_ids': goods_ids}, 'json', 'post', tableIns);
        }
        , updateQrcode: function () {//批量更新二维码
            var checkStatus = table.checkStatus('goodsListTable')
                , data = checkStatus.data;
            // layer.alert(JSON.stringify(data));
            if (data.length == 0) {
                layer.msg('选中了：' + data.length + ' 个');
                return false;
            }
            //商品软删除
            var goods_ids = '';
            $.each(data, function (k, val) {
                goods_ids += val.goods_id + ','
            });
            goods_ids=StrTrimRight(goods_ids);
            var url = urlConfig.goods.updateQrcode;
            ajaxRequest.ajaxRequest(url, {'goods_ids': goods_ids}, 'json', 'post', tableIns);
        }
        , getCheckLength: function () { //获取选中数目
            var checkStatus = table.checkStatus('goodsListTableID')
                , data = checkStatus.data;
            layer.msg('选中了：' + data.length + ' 个');
        }
        , isAll: function () { //验证是否全选
            var checkStatus = table.checkStatus('goodsListTableID');
            layer.msg(checkStatus.isAll ? '全选' : '未全选')
        }
    };
    //调用批量处理方法
    $('.goods-Table-btn .layui-btn').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
});

/**
 * 1.功能描述:二维码点击放大
 * 2.创造者:yfl
 * 2018年6月12日10:33:48
 */

$(document).on('click','.QRcode',function () {
    var obj=$(this);
    obj.css('width','300px');
    layer.open({
        type: 1,
        title: false,
        closeBtn:0,
        shadeClose: true,
        content: $('#'+obj.attr('id')),
        end:function(){
            obj.css('width','20px');
        }
    });
});
/**
 * 1.功能描述:商品主图点击放大
 * 2.创造者:yfl
 * 2018年6月13日19:32:36
 */
$(document).on('click','.album_picture',function () {
    var obj=$(this);
    obj.css('width','700px');
    layer.open({
        type: 1,
        title: false,
        closeBtn:0,
        shadeClose: true,
        // area:['700px','700px'],
        content: $('#'+obj.attr('id')),
        end:function(){
            obj.css('width','20px');
        }
    });
});
