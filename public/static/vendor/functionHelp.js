/**
 * 1.功能描述:去掉字符串最后一个逗号
 * 2.创造者:yfl
 * 2018年6月12日10:33:48
 */
function StrTrimRight(str) {
    return (str.substring(str.length - 1) == ',') ? str.substring(0, str.length - 1) : str;
}

/**
 * 1.功能描述:打印到控制台
 * 2.创造者:yfl
 * 2018年6月12日10:33:48
 */
function _console(data) {
    console.log(data);
}

function IsMobilePhoneNumber(input) {
    // var regex = /^((\+)?86|((\+)?86)?)0?1[3458]\d{9}$/;
    var regex = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
    if (regex.test(input)) {
        return true;
    } else {
        return false;
    }
}

//验证电子邮箱
function IsEmail(input) {
    var regex = /^([\w-\.]+)@([\w-\.]+)(\.[a-zA-Z0-9]+)$/;
    if (regex.test(input)) {
        return true;
    } else {
        return false;
    }
}

function isEmail2(input) {
    var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
    if (pattern.test(input)) {
        return true;
    } else {
        return false;
    }
}

//不能有特殊字符
function IsChar(input) {
    if (new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(input)) {
        return true;
    } else {
        return false;
    }
}

//首尾不能出现下划线
function IsLine(input) {
    if (/(^\_)|(\__)|(\_+$)/.test(value)) {
        return true;
    } else {
        return false;
    }
}

//不能全为数字
function IsNotNum(input) {
    var regex = /^\d+\d+\d$/;
    if (regex.test(input)) {
        return true;
    } else {
        return false;
    }
}

//验证只包含数字和英文字母  
function IsIntegerAndEnglishCharacter(input) {
    var regex = /^[0-9A-Za-z]+$/;
    if (regex.test(input)) {
        return true;
    } else {
        return false;
    }
}