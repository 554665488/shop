
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
function _console(data){
    console.log(data);
}