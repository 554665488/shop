/**
 * Created by 554665488 on 2018-5-20.
 */
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});


function fleshVerify() {
    //重载验证码
//          $('#imgVerify').attr('src','/index.php?m=Admin&c=Admin&a=vertify&r='+Math.floor(Math.random()*100));
    $('#imgVerify').attr('src', '/verify' + '/' + Math.floor(Math.random() * 100));

}


jQuery.fn.center = function () {
    this.css("position", "absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
        $(window).scrollTop()) - 30 + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
        $(window).scrollLeft()) + "px");
    return this;
}

function checkLogin() {
    var username = $('#username').val();
    var password = $('#password').val();
    var verify = $('input[name="verify"]').val();
    // if( username == '' || password ==''){
    //     layer.alert('用户名或密码不能为空', {icon: 2}); //alert('用户名或密码不能为空');
    //     return;
    // }
    /*if(vertify ==''){
     layer.alert('验证码不能为空', {icon: 2});
     return;
     }
     if(vertify.length !=4){
     layer.alert('验证码错误', {icon: 2});
     //fleshVerify();
     return;
     }*/
    var index;
    $.ajax({
//  			url:'/yourbi/index.php?m=Admin&c=Admin&a=login&t='+Math.random(),
        url: "/admin/login",
        type: 'post',
        dataType: 'json',
        data: {
            username: username,
            password: password,
            verify: verify
        },
        beforeSend: function (XMLHttpRequest) {
            index = layer.load(1,{time: 2 * 1000}); //换了种风格
        },
        complete: function (XMLHttpRequest) { //请求完成时运行的函数（在请求成功或失败之后均调用，即在 success 和 error 函数之后）。
            layer.close(index);
        },
        success: function (res) {
            if (res.status == false) {
                //表单验证
                if (res.additional.scene == 'verify') {
                    $.each(res.msg, function ($k, $v) {
                        layer.tips($v, '#' + $k);
                        return false;
                    });
                    return false;
                }
                //登录失败
                layer.msg(res.msg, {icon: 5});
                return false;
            }

            //登录成功
            if (res.status == true) {
                layer.msg(res.msg + '请等待....',{icon:1});
                setTimeout(function(){
                    top.location.href = "/admin/Aindex";
                },1000);
                return false;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            layer.alert('网络失败，请刷新页面后重试', {icon: 2});
        }
    })
}

document.onkeydown = function (event) {
    e = event ? event : (window.event ? window.event : null);
    if (e.keyCode == 13) {
        checkLogin();
    }
};
