layui.define(['jquery', 'form'], function (exports) { //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
    /**
     *554665488@qq.com 2017年3月1日 星期三
     * @param  请求的url
     * @param data 发送的数据
     * @type 请求方式 get post
     * @param way true刷新当前页 ; false 刷新 父级
     * @param page 分页
     * @param dataType 返回的类型 html json xml
     * @param tableIns  表格重载对象
     * @constructor
     */
    var fun = {
        ajaxRequest: function (url, data, dataType, type, tableIns) {
            $ = layui.jquery;
            var form = layui.form;
            var index;
            $.ajax({
                url: url,
                dataType: dataType,
                type: type,
                data: data,
                cache: false,
                async: true,
                beforeSend: function (XMLHttpRequest) {
                    index = layer.load(2, {time: 5 * 1000}); //又换了种风格，并且设定最长等待10秒
                },
                complete: function (XMLHttpRequest) { //请求完成时运行的函数（在请求成功或失败之后均调用，即在 success 和 error 函数之后）。
                    layer.close(index);
                },
                success: function (json) {
                    if (json.status == false) {
                        layer.msg(json.msg, {icon: 5});//失败的表情
                        return false;
                    } else if (json.status == true) {
                        layer.msg(json.msg, {
                            icon: 6,//成功的表情
                            time: 3000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            // 表格数据修改后重载
                            setTimeout(function () {
                                tableIns.reload({
                                    where: { //设定异步数据接口的额外参数，任意设
                                        // aaaaaa: 'xxx'
                                        // ,bbb: 'yyy'
                                        // //…
                                    }, page: {
                                        curr: tableIns.config.page.curr  //重新从第 当前页 页开始
                                    }
                                });
                            }, 1000)
                        });
                    }
                    return false;
                },
                error: function () {
                    layer.msg('请求失败.或者没有权限。', {icon: 2})
                }
            });
            return false;//阻止表单跳转
        },
        delData: function (url, sendData, dataType, type,tableIns) { //删除 后自动消失
            layer.confirm('确定删除吗？', {
                btn: ['确定', '取消']
            }, function () {
                var index;
                $.ajax({
                    url: url,
                    dataType: dataType,
                    type: type,
                    data: sendData,
                    cache: false,
                    async: true,
                    beforeSend: function (XMLHttpRequest) {
                        index = layer.load(2, {time: 5 * 1000}); //又换了种风格，并且设定最长等待10秒
                    },
                    complete: function (XMLHttpRequest) { //请求完成时运行的函数（在请求成功或失败之后均调用，即在 success 和 error 函数之后）。
                        layer.close(index);
                    },
                    success: function (json) {
                        if (json.status == false) {
                            layer.msg(json.msg, {icon: 5});//失败的表情
                            return false;
                        } else if (json.status) {
                            layer.msg(json.msg, {
                                icon: 6,//成功的表情
                                time: 3000 //2秒关闭（如果不配置，默认是3秒）
                            },function () {
                                // obj.del();////删除对应行（tr）的DOM结构，并更新缓存
                                //表格渲染的重载
                                console.log(tableIns);
                                tableIns.reload({
                                    where: { //设定异步数据接口的额外参数，任意设
                                        // aaaaaa: 'xxx'
                                        // ,bbb: 'yyy'
                                        // //…
                                    }, page: {
                                        curr: tableIns.config.page.curr  //重新从第 当前页 页开始
                                    }
                                });
                            });
                        }
                        return false;
                    },
                    error: function () {
                        layer.msg('请求失败.或者没有权限。', {icon: 2})
                    }
                });

            })
        },
        getHtml: function (url, id, title, Width, Height) {  //编辑信息 get请获得页面

            $.get(url, {id: id}, function (data) {
                if (data.status == 'error') {
                    layer.msg(data.msg, {icon: 5});
                    return;
                }
                layer.open({
                    title: title,
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    shadeClose: true,
                    shade: 0.5,
                    area: [Width + 'px', Height + 'px'],
                    moveOut: true,
                    maxmin: true,
                    content: data
                });
                var form = layui.form();
                form.render();
            });
        },
        addGetHtml: function (url, title, Width, Height) {  //添加信息 get请获得页面
            $.get(url, function (data) {
                if (data.status == 'error') {
                    layer.msg(data.msg, {icon: 5});
                    return;
                }
                layer.open({
                    title: title,
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    shadeClose: true,
                    shade: 0.5,
                    area: [Width + 'px', Height + 'px'],
                    moveOut: true,
                    maxmin: true,
                    content: data
                });
                var form = layui.form();
                form.render();
            });
        },
        /*弹出层*/
        /*
         参数解释：
         title	标题
         url		请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        layer_show: function (title, url, w, h) {
            if (title == null || title == '') {
                title = false;
            }
            ;
            if (url == null || url == '') {
                url = "404.html";
            }
            ;
            if (w == null || w == '') {
                w = 800;
            }
            ;
            if (h == null || h == '') {
                h = ($(window).height() - 50);
            }
            ;
            layer.open({
                type: 1,
                area: [w + 'px', h + 'px'],
                fix: false, //不固定
                maxmin: true,
                shade: 0.4,
                title: title,
                content: url
            });
        },
        ajaxMsgWord: function (url, data, msg) {
            var index = layer.msg(msg, {icon: 16, shade: 0.01, time: 1000 * 30});
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                dataType: 'json',
                cache: false,
                async: true,
                beforeSend: function (XHR) {

                },
                complete: function () {
                    layer.close(index);
                },
                success: function (json) {
                    console.log(json);
                    if (json.status == 'error') {
                        layer.msg(json.msg, {icon: 5});
                        return false;
                    }
                    if (json.status == 'success') {
                        layer.msg(json.msg, {
                            icon: 6,//成功的表情
                            time: 3000 //2秒关闭（如果不配置，默认是3秒）
                        });
                    }
                },
                error: function () {
                    layer.msg('请求失败...或没有权限。', {icon: 2})
                }
            });
            return false;
        },
        lookMagnifyImg: function (id, width, height) {
            layer.open({
                type: 1,
                title: false,
                closeBtn: 1,
                shade: 0,
                fixed: false,
                area: [width + 'px', height + 'px'],
                skin: 'layui-layer-project{background:#c00;}', //没有背景色
                shadeClose: true,
                content: $('#' + id)
            });
        },
        /**
         *
         * @param: 请求的地址
         * @param: type 请求的类型 get
         * @param: dataType json html text
         * @param: that 容器的this
         */
        loadHtmlBySelect: function (that, url, data) {
            that.load(url, data, function (response, status, xhr) {
                var form = layui.form;

                if (status == "success") {
                    if (response == '') {
                        form.render('select');
                    }
                    form.render('select');
                }
                if (status == "error") {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }

            });
        },
        loadTableHtml: function (that, url) {
            that.load(url, function (response, status, xhr) {
                var form = layui.form;
                if (status == "success") {
                    that.html(response);
                    form.render();
                }
                if (status == "error") {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }

            });
        }

    };
    //输出test接口输出test接口
    exports('ajaxRequest', fun);
});