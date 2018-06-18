$(document).ready(function () {


    $('#btnLogin').on('click', function () {
        var account = $('#account').val(), password = $('#password').val();
        _console(account);

        if (IsEmail(account) == false && IsMobilePhoneNumber(account) == false) {
            layer.tips('请输入正确的邮箱或者手机号', "#account", {tips: [2, 'red']});
            return false;
        }
        if (password.length == '') {
            layer.tips('请输入密码', "#password", {tips: [2, 'red']});
            return false;
        }
        $.ajax({
            type: "post",
            url: urlConfig.user.login,
            data: {"account": account, 'password': password},
            beforeSend: function () {
                index = layer.load(1, {time: 2 * 1000});
                $("#btnLogin").attr("disabled", 'disabled').addClass('layui-btn-disabled');
            },
            complete: function () {
                $("#btnLogin").removeAttr("disabled").removeClass('layui-btn-disabled');
                layer.close(index);
            },
            success: function (data) {
                console.log(data);
                if (data.status == true) {

                    window.location.href = shop_main + '/index/index/index.html';
                } else {
                    layer.msg(data.msg,{icon:2});
                }
                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
            }
        });
    });
});

//验证手机号码号码
//登录
// function verifyUsername(username) {
//
//     var is_true = 0;
//     if (/.*[\u4e00-\u9fa5]+.*$/.test(username)) {
//         is_true = 1;
//         $("#emailregistermodel-munber").trigger("focus");
//         $('#emailregistermodel-munber').css("border", "1px solid red");
//         $("#usernameyz").css("color", "red").text("手机号码号码中不能包含汉字");
//         return is_true;
//     }
//     if (/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(username)) {
//         is_true = 1;
//         $("#emailregistermodel-munber").trigger("focus");
//         $('#emailregistermodel-munber').css("border", "1px solid red");
//         $("#usernameyz").css("color", "red").text("手机号码号码不能是邮箱");
//         return is_true;
//     }
//     var username_verify = "q,e,k";
//     var usernme_verify_array = new Array();
//     if ($.trim(username_verify) != "" && username_verify != undefined) {
//         usernme_verify_array = username_verify.split(",");
//     }
//     usernme_verify_array.push(",");
//     $.each(usernme_verify_array, function (k, v) {
//         if ($.trim(v) != "") {
//             if (username.indexOf(v) >= 0) {
//                 is_true = 1;
//                 $("#emailregistermodel-munber").trigger("focus");
//                 $('#emailregistermodel-munber').css("border", "1px solid red");
//                 $("#usernameyz").css("color", "red").text("手机号码号码中不能包含'" + v + "'这样的字符");
//                 return false;
//             }
//         }
//     });
//     return is_true;
// }
//
// //验证密码
// function verifyPassword(password) {
//     var is_true = 0;
//     var min_length_str = "6";
//     if ($.trim(min_length_str) != "") {
//         var min_length = parseInt(min_length_str);
//     } else {
//         var min_length = 5;
//     }
//     if ($.trim(password) == "") {
//         is_true = 1;
//         $("#password").trigger("focus");
//         $("#password").css("border", "1px solid red");
//         $("#yzpassword").css("color", "red").text("密码不能为空");
//         return is_true;
//     } else {
//         $("#password").css("border", "1px solid #ccc");
//         $("#yzpassword").css("color", "red").text("");
//     }
//     if (min_length > 0) {
//
//         if (password.length < min_length) {
//             is_true = 1;
//             $("#password").trigger("focus");
//             $("#password").css("border", "1px solid red");
//             $("#yzpassword").css("color", "red").text("密码最小长度为" + min_length);
//             return is_true;
//         } else {
//             $("#password").css("border", "1px solid #ccc");
//             $("#yzpassword").css("color", "red").text("");
//         }
//
//     } else {
//
//     }
//
//     //验证汉字
//     if (/.*[\u4e00-\u9fa5]+.*$/.test(password)) {
//         is_true = 1;
//         $("#password").trigger("focus");
//         $("#password").css("border", "1px solid red");
//         $("#yzpassword").css("color", "red").text("密码中不能包含汉字!");
//         return is_true;
//     } else {
//         $("#password").css("border", "1px solid #ccc");
//         $("#yzpassword").css("color", "red").text("");
//     }
//     var regex_str = "number";
//     if ($.trim(regex_str) != "" && regex_str != undefined) {
//         //验证是否包含数字
//         if (regex_str.indexOf("number") >= 0) {
//             var number_test = /[0-9]/;
//             if (!number_test.test(password)) {
//                 is_true = 1;
//                 $("#password").trigger("focus");
//                 $("#password").css("border", "1px solid red");
//                 $("#yzpassword").css("color", "red").text("密码中必须包含数字!");
//                 $('#emailregistermodel-munber').css("border", "1px solid #ccc");
//                 $("#usernameyz").css("color", "red").text("");
//                 return is_true;
//             } else {
//                 $("#password").css("border", "1px solid #ccc");
//                 $("#yzpassword").css("color", "red").text("");
//             }
//         }
//         //验证是否包含小写字母
//         if (regex_str.indexOf("letter") >= 0) {
//             var letter_test = /[a-z]/;
//             if (!letter_test.test(password)) {
//                 is_true = 1;
//                 $("#password").trigger("focus");
//                 $("#password").css("border", "1px solid red");
//                 $("#yzpassword").css("color", "red").text("密码中必须包含小写字母!");
//                 $('#emailregistermodel-munber').css("border", "1px solid #ccc");
//                 $("#usernameyz").css("color", "red").text("");
//                 return is_true;
//             } else {
//                 $("#password").css("border", "1px solid #ccc");
//                 $("#yzpassword").css("color", "red").text("");
//             }
//         }
//         //验证是否包含大写字母
//         if (regex_str.indexOf("upper_case") >= 0) {
//             var upper_case_test = /[A-Z]/;
//             if (!upper_case_test.test(password)) {
//                 is_true = 1;
//                 $("#password").trigger("focus");
//                 $("#password").css("border", "1px solid red");
//                 $("#yzpassword").css("color", "red").text("密码中必须包含大写字母!");
//                 $('#emailregistermodel-munber').css("border", "1px solid #ccc");
//                 $("#usernameyz").css("color", "red").text("");
//                 return is_true;
//             } else {
//                 $("#password").css("border", "1px solid #ccc");
//                 $("#yzpassword").css("color", "red").text("");
//             }
//         }
//         //验证是否包含特殊字符
//         if (regex_str.indexOf("symbol") >= 0) {
//             var symbol_test = /[^A-Za-z0-9]/;
//             if (!symbol_test.test(password)) {
//                 is_true = 1;
//                 $("#password").trigger("focus");
//                 $("#password").css("border", "1px solid red");
//                 $("#yzpassword").css("color", "red").text("密码中必须包含符号!");
//                 $('#emailregistermodel-munber').css("border", "1px solid #ccc");
//                 $("#usernameyz").css("color", "red").text("");
//                 return is_true;
//             } else {
//                 $("#password").css("border", "1px solid #ccc");
//                 $("#yzpassword").css("color", "red").text("");
//             }
//         }
//     }
//     return is_true;
// }

// 用户信息验证
// let userInfoCheck = (type) =
// >
// {
//     var munber = $("#emailregistermodel-munber").val();
//     if (munber == '') {
//         alert('请输入号码');
//         return;
//     }
//     $.ajax({
//         url: '{:URL("home/login/userInfoCheck")}',
//         type: 'post',
//         data: {
//             type: type,
//             number: munber
//         },
//         dataType: 'json',
//         success: function (msg) {
//             console.log(msg);
//             alert(msg.msg);
//         }, error: function () {
//             alert(11);
//         }
//     })
// }
$(function () {

    //二维码、PC登录切换
    $('.qrcode-target').click(function () {
        if ($(this).hasClass('btn-qrcode')) {
            $(this).removeClass('btn-qrcode').addClass('btn-login').attr('title', '去电脑登录');
            $('.login-wrap').hide();
            $('.login-mobile').show();
            return;
        }
        if ($(this).hasClass('btn-login')) {
            $(this).removeClass('btn-login').addClass('btn-qrcode').attr('title', '去手机扫码登录');
            $('.login-wrap').show();
            $('.login-mobile').hide();
        }
    });

});