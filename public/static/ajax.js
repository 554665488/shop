var index;
$.ajax({
    url: "/admin/login",
    type: 'post',
    dataType: 'json',
    data: {},
    beforeSend: function () {
        index = layer.load(1,{time: 2 * 1000});
    },
    complete: function () {
        layer.close(index);
    },
    success: function (res) {

        // layer.tips($v, '#' + $k);
        // layer.msg(res.msg, {icon: 5});
        //登录成功
        // layer.msg(res.msg + '请等待....',{icon:1});
        // setTimeout(function(){
        //     top.location.href = "/admin/Aindex";
        // },1000);
        // return false;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
        layer.alert('网络失败，请刷新页面后重试', {icon: 2});
    }
});