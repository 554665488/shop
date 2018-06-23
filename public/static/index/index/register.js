/**
 * 功能描述:短信注册 和邮箱注册
 * 作者:yfl
 * 2018年6月18日21:24:44
 * QQ:554665488
 */
//短信注册
layui.use(['form'], function () {
    var form = layui.form
        , layer = layui.layer;
    $(document).ready(function () {
        //验证手机号是否已经存在
        $("#phone").on('change', function () {
            var phone = $(this).val();
            if (IsMobilePhoneNumber(phone) == false) {
                layer.tips('请输入正确的手机号', "#phone", {tips: [2, 'red']});
                return false;
            }
            $.ajax({
                type: "post",
                url: urlConfig.user.ajaxIsUserExist,
                data: {"account": phone},
                beforeSend: function () {
                    index = layer.load(1, {time: 2 * 1000});
                },
                complete: function () {
                    layer.close(index);
                },
                success: function (data) {
                    if (data.status == true) {
                        $("#sendSmsCode").removeAttr("disabled").removeClass('layui-btn-disabled');
                        layer.tips(data.msg, "#phone", {tips: [2, 'green']});
                    } else {
                        layer.tips(data.msg, "#phone", {tips: [2, 'red']});
                    }
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
        });
        //提交注册
        form.on('submit(register)', function (data) {

            if (IsMobilePhoneNumber(data.field.phone) == false) {
                layer.tips('请输入正确的手机号', "#phone", {tips: [2, 'red']});
                return false;
            }
            if (IsIntegerAndEnglishCharacter(data.field.repassword) == false) {
                layer.tips('密码只包含数字和英文字母', "#repassword", {tips: [2, 'red']});
                return false
            }
            if (data.field.code.length != 4) {
                layer.tips('验证码必须4位数字', "#code", {tips: [2, 'red']});
                return false
            }
            if (data.field.password.length < 6 || data.field.password.length > 20) {
                layer.tips('密码长度6-20字符', "#password", {tips: [2, 'red']});
                return false
            }
            if (IsChar(data.field.user_name) == false) {
                layer.tips('用户名不能有特殊字符', "#user_name", {tips: [2, 'red']});
                return false
            }
            if (data.field.user_name.length < 5 || data.field.user_name.length > 10) {
                layer.tips('用户名长度5-10字符', "#user_name", {tips: [2, 'red']});
                return false
            }

            if (data.field.repassword != data.field.password) {
                layer.tips('密码不一致', "#repassword", {tips: [2, 'red']});
                return false
            }
            $.ajax({
                type: "post",
                url: urlConfig.user.Register,
                data: data.field,
                beforeSend: function () {
                    $('#sms-register').addClass('layui-btn-disabled').attr('disabled', 'disabled');
                    index = layer.load(1, {time: 2 * 1000});
                },
                complete: function () {
                    $('#sms-register').removeClass('layui-btn-disabled').removeAttr('disabled');
                    layer.close(index);
                },
                success: function (data) {
                    if (data.status == false) {
                        layer.alert(data.msg, {icon: 2});
                        return false;
                    } else {
                        window.location.href = shop_main + '/index/index/index.html';
                    }
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
            return false;
        });
        //发送验证码开始
        var getSmsCode = function () {

            var sendTo = $('#phone').val();
            if (IsMobilePhoneNumber(sendTo) == false) {
                layer.tips('请输入正确的手机号', "#phone", {tips: [2, 'red']});
                return false;
            }
            sendCode(sendTo);
        };
        $('#sendSmsCode').on('click', getSmsCode);

        //ajax 请求发送
        function sendCode(sendTo) {
            $.ajax({
                type: "post",
                url: urlConfig.user.sendCode,
                data: {sendTo: sendTo},
                beforeSend: function () {
                    index = layer.load(1, {time: 2 * 1000});
                },
                complete: function () {
                    layer.close(index);
                },
                success: function (data) {
                    _console(data);
                    if (data.status == false) {
                        layer.alert(data.msg, {icon: 2});
                        return false;
                    } else {
                        layer.msg(data.msg);
                        run_time();//发送成功开启定时器
                    }
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
        }

        //定时器
        var wait = 120;

        function run_time() {
            var obj = $("#sendSmsCode");
            if (wait == 0) {
                obj.on('click', getSmsCode);
                obj.removeAttr("disabled").removeClass('layui-btn-disabled');
                obj.html("获取验证码");
                wait = 120;
            } else {
                obj.off('click');
                obj.attr("disabled", 'disabled').addClass('layui-btn-disabled');
                obj.html(wait + "s后重新发送");
                wait--;
                setTimeout(function () {
                    run_time();
                }, 1000);
            }
        }

        //发送验证码结束
    });
});


//邮箱注册
layui.use(['form'], function () {
    var form = layui.form
        , layer = layui.layer;
    $(document).ready(function () {
        //验证邮箱是否已经存在
        $("#email").on('change', function () {
            var email = $(this).val();
            if (IsEmail(email) == false) {
                layer.tips('请输入正确的邮箱', "#email", {tips: [2, 'red']});
                return false;
            }
            $.ajax({
                type: "post",
                url: urlConfig.user.ajaxIsUserExist,
                data: {"account": email},
                beforeSend: function () {
                    index = layer.load(1);
                },
                complete: function () {
                    layer.close(index);
                },
                success: function (data) {
                    if (data.status == true) {
                        $("#sendEmailCode").removeAttr("disabled").removeClass('layui-btn-disabled');
                        layer.tips(data.msg, "#email", {tips: [2, 'green']});
                    } else {
                        layer.tips(data.msg, "#email", {tips: [2, 'red']});
                    }
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
        });
        //提交注册
        form.on('submit(email-register)', function (data) {
            if (IsEmail(data.field.email) == false) {
                layer.tips('请输入正确的邮箱', "#email", {tips: [2, 'red']});
                return false;
            }
            if (IsIntegerAndEnglishCharacter(data.field.repassword) == false) {
                layer.tips('密码只包含数字和英文字母', "#repassword", {tips: [2, 'red']});
                return false
            }
            if (data.field.code.length != 4) {
                layer.tips('验证码必须4位数字', "#code", {tips: [2, 'red']});
                return false
            }
            if (data.field.password.length < 6 || data.field.password.length > 20) {
                layer.tips('密码长度6-20字符', "#password", {tips: [2, 'red']});
                return false
            }
            if (IsChar(data.field.user_name) == false) {
                layer.tips('用户名不能有特殊字符', "#user_name", {tips: [2, 'red']});
                return false
            }
            if (data.field.user_name.length < 5 || data.field.user_name.length > 10) {
                layer.tips('用户名长度5-10字符', "#user_name", {tips: [2, 'red']});
                return false
            }
            if (data.field.repassword != data.field.password) {
                layer.tips('密码不一致', "#repassword", {tips: [2, 'red']});
                return false
            }
            $.ajax({
                type: "post",
                url: urlConfig.user.emailRegister,
                data: data.field,
                beforeSend: function () {
                    $('#sms-register').addClass('layui-btn-disabled').attr('disabled', 'disabled');
                    index = layer.load(1);
                },
                complete: function () {
                    $('#sms-register').removeClass('layui-btn-disabled').removeAttr('disabled');
                    layer.close(index);
                },
                success: function (data) {
                    if (data.status == false) {
                        layer.alert(data.msg, {icon: 2});
                        return false;
                    } else {
                        window.location.href = shop_main + '/index/index/index.html';
                    }
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
            return false;
        });
        //发送验证码开始
        var getEmailCode = function () {

            var sendTo = $('#email').val();
            if (IsEmail(sendTo) == false) {
                layer.tips('请输入正确的邮箱', "#phone", {tips: [2, 'red']});
                return false;
            }
            sendCode(sendTo);
        };
        $('#sendEmailCode').on('click', getEmailCode);

        //ajax 请求发送
        function sendCode(sendTo) {
            $.ajax({
                type: "post",
                url: urlConfig.user.sendCode,
                data: {sendTo: sendTo},
                beforeSend: function () {
                    index = layer.load(1);
                },
                complete: function () {
                    layer.close(index);
                },
                success: function (data) {
                    if (data.status == false) {
                        layer.alert(data.msg, {icon: 2});
                        return false;
                    } else {
                        layer.msg(data.msg);
                        run_time();//发送成功开启定时器
                    }
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
        }

        //定时器
        var wait = 120;

        function run_time() {
            var obj = $("#sendEmailCode");
            if (wait == 0) {
                obj.on('click', getEmailCode);
                obj.removeAttr("disabled").removeClass('layui-btn-disabled');
                obj.html("获取验证码");
                wait = 120;
            } else {
                obj.off('click');
                obj.attr("disabled", 'disabled').addClass('layui-btn-disabled');
                obj.html(wait + "s后重新发送");
                wait--;
                setTimeout(function () {
                    run_time();
                }, 1000);
            }
        }

        //发送验证码结束
    });
});


