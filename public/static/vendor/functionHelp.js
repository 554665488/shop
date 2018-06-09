//去掉字符串最后一个逗号
function StrTrimRight(str) {
    return (str.substring(str.length - 1) == ',') ? str.substring(0, str.length - 1) : str;
}