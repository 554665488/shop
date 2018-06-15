<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 定义常量

use think\facade\Request;

//define('DOMAIN_NAME_VISIT', 'http://101.200.59.92:9555' . Request::server('SCRIPT_NAME') . '/');   //http://101.200.59.92:9555/index.php/
define('DOMAIN_NAME_VISIT', 'http://106.14.120.16:9555' . '/');   //http://101.200.59.92:9555/index.php/
// 模块名
define('INDEX_MODEL', 'index');
define('WAP_MODEL', 'wap');
define('TEST_MODEL', 'test');
define('ADMIN_MODEL', 'admin');
// 项目文件指定根目录
define('PROJECT_ROOT', __DIR__ . '/..');  //项目根目录地址
define('__HTTP_HOST','http://'.\think\facade\Request::server('HTTP_HOST'));
// 应用公共文件
function ajaxReturn($code, $msg = '处理成功')
{
    return [
        'code' => $code,
        'msg' => $msg
    ];
}

/**
 * @description:制造门面代理
 * @time: 2018-5-23 00:05:19
 * @Author: yfl
 * @QQ 554665488
 */
function makeFacade()
{
    \think\Facade::bind([
        'app\common\facade\SCFacade' => 'app\common\SC',
        'app\common\facade\TreeFacade' => 'app\common\Tree',
        'app\common\facade\TableFacade' => 'app\common\Table',
        'app\common\facade\QRcodeFacade' => 'app\common\QRcodeUtil',
        'app\common\facade\UploadFacade' => 'app\common\UploadUtil',
    ]);
    //类的映射
    \think\Loader::addClassAlias([
        'SC' => 'app\common\facade\SCFacade',
        'Tree' => 'app\common\facade\TreeFacade',
        'Table' => 'app\common\facade\TableFacade',
        'QRcodeUtil' => 'app\common\facade\QRcodeFacade',
        'UploadUtil' => 'app\common\facade\UploadFacade',
    ]);
}

makeFacade();
if (!function_exists('_pre')) {
    function _pre($data, $flog = false)
    {
        echo '<pre>';
        print_r($data);
        if ($flog) exit;
        echo '</pre>';
    }
}
function i_array_column($input, $columnKey, $indexKey = null)
{
    if (!function_exists('array_column')) {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? true : false;
        $indexKeyIsNull = (is_null($indexKey)) ? true : false;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? true : false;
        $result = array();
        foreach ((array)$input as $key => $row) {
            if ($columnKeyIsNumber) {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null;
            } else {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : null;
            }
            if (!$indexKeyIsNull) {
                if ($indexKeyIsNumber) {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key)) ? current($key) : null;
                    $key = is_null($key) ? 0 : $key;
                } else {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    } else {
        return array_column($input, $columnKey, $indexKey);
    }
}

/**
 * @description: 递归菜单
 * @author: 554665488@qq.com(2016年8月7日)
 * @param array $array
 * @param number $fid
 * @param number $level
 * @param number $type 1:顺序菜单 2树状菜单
 * @return array:number
 */
function get_column($array, $type = 1, $fid = 0, $level = 0)
{
    $column = array();
    if ($type == 2) {
        foreach ($array as $key => $vo) {
            if ($vo['pid'] == $fid) {
                $vo['level'] = $level;
                $column[$key] = $vo;
                $column [$key][$vo['id']] = get_column($array, $type = 2, $vo['id'], $level + 1);
            }
        }
    } else {
        foreach ($array as $key => $vo) {
            if ($vo['pid'] == $fid) {
                $vo['level'] = $level;
                $column[] = $vo;
                $column = array_merge($column, get_column($array, $type = 1, $vo['id'], $level + 1));
            } else {
                //父级ID与一级pid=0相等的为为二级菜单
            }
        }
    }

    return $column;
}

/**
 * @param $number
 * @param int $num
 * @return string
 * 格式化数字
 */
function mj_number_format($number, $num = 2)
{
    if (strstr($number, '.')) {
        $p = stripos($number, '.');  //4

        $tmp = substr($number, 0, $p + 3);  //1000.00

    } else {
        $tmp = $number;
    }
    return number_format($tmp, $num);//number_format  通过千位数格式化字符串
}

/**
 * +----------------------------------------------------------
 * 功能：将一个字符串转换成数组，支持中文
 * @param string $string 待转换成数组的字符串
 * @return string   转换后的数组
 * +----------------------------------------------------------
 */
function strToArray($string)
{
    $strlen = mb_strlen($string);
    while ($strlen) {
        $array[] = mb_substr($string, 0, 1, "utf8");
        $string = mb_substr($string, 1, $strlen, "utf8");
        $strlen = mb_strlen($string);
    }
    return $array;
}

/**
 * +----------------------------------------------------------
 * 功能：生成随机字符串
 * @param int $length 要生成的随机字符串长度
 * @param string $type 随机码类型：0，数字+大写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
 * @return string
 * +----------------------------------------------------------
 */
function randCode($length = 5, $type = 0)
{
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } else if ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $code = '';
    $count = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str[$i] = $string[rand(0, $count)];
        $code .= $str[$i];
    }
    return $code;
}

/**
 * +-----------------------------------------------------------------------------------------
 * 功能：删除目录及目录下所有文件或删除指定文件
 * @param str $path 待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 * +-----------------------------------------------------------------------------------------
 */
function delDirAndFile($path, $delDir = FALSE)
{
    if (is_dir($path)) {
        $handle = opendir($path);
        if ($handle) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..")
                    is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
            }
            closedir($handle);
            if ($delDir)
                return rmdir($path);
        }
    } else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return 0;
        }
    }
}

/**
 * @description:删除一个文件而不是目录
 * @time:2018-6-11 23:06:30
 * @Author: yfl
 * @QQ 554665488
 * @param $path
 * @return bool|int
 */
function delFile($path)
{
    if (file_exists($path) && is_file($path)) {
        return unlink($path);
    } else {
        return 0;
    }
}

/**
 * +----------------------------------------------------------
 * 功能：将一个字符串部分字符用*替代隐藏
 * @param string $string 待转换的字符串
 * @param int $bengin 起始位置，从0开始计数，当$type=4时，表示左侧保留长度
 * @param int $len 需要转换成*的字符个数，当$type=4时，表示右侧保留长度
 * @param int $type 转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
 * @param string $glue 分割符
 * @return string   处理后的字符串
 * +----------------------------------------------------------
 */
function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@")
{
    if (empty($string))
        return false;
    $array = array();
    if ($type == 0 || $type == 1 || $type == 4) {
        $strlen = $length = mb_strlen($string);
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, "utf8");
            $string = mb_substr($string, 1, $strlen, "utf8");
            $strlen = mb_strlen($string);
        }
    }
    switch ($type) {
        case 1:
            $array = array_reverse($array);
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", array_reverse($array));
            break;
        case 2:
            $array = explode($glue, $string);
            $array[0] = hideStr($array[0], $bengin, $len, 1);
            $string = implode($glue, $array);
            break;
        case 3:
            $array = explode($glue, $string);
            $array[1] = hideStr($array[1], $bengin, $len, 0);
            $string = implode($glue, $array);
            break;
        case 4:
            $left = $bengin;
            $right = $len;
            $tem = array();
            for ($i = 0; $i < ($length - $right); $i++) {
                if (isset($array[$i]))
                    $tem[] = $i >= $left ? "*" : $array[$i];
            }
            $array = array_chunk(array_reverse($array), $right);
            $array = array_reverse($array[0]);
            for ($i = 0; $i < $right; $i++) {
                $tem[] = $array[$i];
            }
            $string = implode("", $tem);
            break;
        default:
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", $array);
            break;
    }
    return $string;
}

/**
 * +----------------------------------------------------------
 * 功能：字符串截取指定长度
 * leo.li hengqin2008@qq.com
 * @param string $string 待截取的字符串
 * @param int $len 截取的长度
 * @param int $start 从第几个字符开始截取
 * @param boolean $suffix 是否在截取后的字符串后跟上省略号
 * @return string               返回截取后的字符串
 * +----------------------------------------------------------
 */
function cutStr($str, $len = 100, $start = 0, $suffix = 1)
{
    $str = strip_tags(trim(strip_tags($str)));
    $str = str_replace(array("\n", "\t"), "", $str);
    $strlen = mb_strlen($str);
    while ($strlen) {
        $array[] = mb_substr($str, 0, 1, "utf8");
        $str = mb_substr($str, 1, $strlen, "utf8");
        $strlen = mb_strlen($str);
    }
    $end = $len + $start;
    $str = '';
    for ($i = $start; $i < $end; $i++) {
        $str .= $array[$i];
    }
    return count($array) > $len ? ($suffix == 1 ? $str . "&hellip;" : $str) : $str;
}

/**
 * +----------------------------------------------------------
 * 功能：计算文件大小
 * @param int $bytes
 * @return string 转换后的字符串
 * +----------------------------------------------------------
 */
function byteFormat($bytes)
{
    $sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $sizetext[$i];
}

/**
 * +----------------------------------------------------------
 * 功能：对象转换成PHP数组
 * @param array $objData 对象数据
 * @return array    转换后的php数组
 * +----------------------------------------------------------
 */
function objToArr($objData)
{
    $ret = array();
    foreach ($objData as $key => $value) {
        if (gettype($value) == 'array' || gettype($value) == 'object') {
            $ret[$key] = objToArr($value);
        } else {
            $ret[$key] = $value;
        }
    }
    return $ret;
}

/**
 * +----------------------------------------------------------
 * 功能：时间转换为几天前
 * @param int $time 时间戳
 * @return string    转换后的字符串
 * +----------------------------------------------------------
 */
function timeFormat($time)
{
    $nowTime = time();
    $dur = $nowTime - $time;
    if ($dur < 0) {
        return $time;
    } else {
        if ($dur < 60) {
            return '<font color="red">' . $dur . '秒前</font>';
        } else {
            if ($dur < 3600) { //1小时内
                return '<font color="red">' . floor($dur / 60) . '分钟前</font>';
            } else {
                if ($dur < 86400) { //1天内
                    return '<font color="red">' . floor($dur / 3600) . '小时前</font>';
                } else {
                    if ($dur < 259200) {//3天内
                        return '<font color="red">' . floor($dur / 86400) . '天前</font>';
                    } else {
                        return date('Y-m-d H:i:s', $time);
                    }
                }
            }
        }
    }
}

//获取用户真实IP
/**
 * @return array|false|string
 */
function getIp()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    elseif (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return ($ip);
}

/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param string $type
 * @return array
 */
function array_sort($arr, $keys, $type = 'desc')
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($key_value);
    } else {
        arsort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * @param 多维数组
 * @return array 一维数组
 */
function array_multi2single($array)
{
    static $result_array = array();
    foreach ($array as $value) {
        if (is_array($value)) {
            array_multi2single($value);
        } else
            $result_array [] = $value;
    }
    return $result_array;
}

/**
 * 友好时间显示
 * @param $time
 * @return bool|string
 */
function friend_date($time)
{
    if (!$time)
        return false;
    $fdate = '';
    $d = time() - intval($time);
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
    if ($d == 0) {
        $fdate = '刚刚';
    } else {
        switch ($d) {
            case $d < $atd:
                $fdate = date('Y年m月d日', $time);
                break;
            case $d < $td:
                $fdate = '后天' . date('H:i', $time);
                break;
            case $d < 0:
                $fdate = '明天' . date('H:i', $time);
                break;
            case $d < 60:
                $fdate = $d . '秒前';
                break;
            case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
                break;
            case $d < $dd:
                $fdate = floor($d / 3600) . '小时前';
                break;
            case $d < $yd:
                $fdate = '昨天' . date('H:i', $time);
                break;
            case $d < $byd:
                $fdate = '前天' . date('H:i', $time);
                break;
            case $d < $md:
                $fdate = date('m月d日 H:i', $time);
                break;
            case $d < $ld:
                $fdate = date('m月d日', $time);
                break;
            default:
                $fdate = date('Y年m月d日', $time);
                break;
        }
    }
    return $fdate;
}

/**
 *   实现中文字串截取无乱码的方法
 */
function getSubstr($string, $start, $length)
{
    if (mb_strlen($string, 'utf-8') > $length) {
        $str = mb_substr($string, $start, $length, 'utf-8');
        return $str . '...';
    } else {
        return $string;
    }
}

/**
 * 判断当前访问的用户是  PC端  还是 手机端  返回true 为手机端  false 为PC 端
 * @return boolean
 */
/**
 *   * 是否移动端访问访问
 *   *
 *   * @return bool
 *   */
function _isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;

    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            return true;
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

//php获取中文字符拼音首字母
function getFirstCharter($str)
{
    if (empty($str)) {
        return '';
    }
    $fchar = ord($str{0});
    if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
    $s1 = iconv('UTF-8', 'gb2312', $str);
    $s2 = iconv('gb2312', 'UTF-8', $s1);
    $s = $s2 == $str ? $s1 : $str;
    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if ($asc >= -20319 && $asc <= -20284) return 'A';
    if ($asc >= -20283 && $asc <= -19776) return 'B';
    if ($asc >= -19775 && $asc <= -19219) return 'C';
    if ($asc >= -19218 && $asc <= -18711) return 'D';
    if ($asc >= -18710 && $asc <= -18527) return 'E';
    if ($asc >= -18526 && $asc <= -18240) return 'F';
    if ($asc >= -18239 && $asc <= -17923) return 'G';
    if ($asc >= -17922 && $asc <= -17418) return 'H';
    if ($asc >= -17417 && $asc <= -16475) return 'J';
    if ($asc >= -16474 && $asc <= -16213) return 'K';
    if ($asc >= -16212 && $asc <= -15641) return 'L';
    if ($asc >= -15640 && $asc <= -15166) return 'M';
    if ($asc >= -15165 && $asc <= -14923) return 'N';
    if ($asc >= -14922 && $asc <= -14915) return 'O';
    if ($asc >= -14914 && $asc <= -14631) return 'P';
    if ($asc >= -14630 && $asc <= -14150) return 'Q';
    if ($asc >= -14149 && $asc <= -14091) return 'R';
    if ($asc >= -14090 && $asc <= -13319) return 'S';
    if ($asc >= -13318 && $asc <= -12839) return 'T';
    if ($asc >= -12838 && $asc <= -12557) return 'W';
    if ($asc >= -12556 && $asc <= -11848) return 'X';
    if ($asc >= -11847 && $asc <= -11056) return 'Y';
    if ($asc >= -11055 && $asc <= -10247) return 'Z';
    return null;
}

/**
 * @param $money
 * @return mixed
 * @description 将金额数字转化为中文大写
 */
function toChineseNumber($money)
{
    $money = round($money, 2);
    $cnynums = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
    $cnyunits = array("圆", "角", "分");
    $cnygrees = array("拾", "佰", "仟", "万", "拾", "佰", "仟", "亿");
    list($int, $dec) = explode(".", $money, 2);
    $dec = array_filter(array($dec[1], $dec[0]));
    $ret = array_merge($dec, array(implode("", cnyMapUnit(str_split($int), $cnygrees)), ""));
    $ret = implode("", array_reverse(cnyMapUnit($ret, $cnyunits)));
    return str_replace(array_keys($cnynums), $cnynums, $ret);
}

//判断一个字符串是否属于序列化后的数据
function is_serialized($data)
{
    $data = trim($data);
    if ('N;' == $data)
        return true;
    if (!preg_match('/^([adObis]):/', $data, $badions))
        return false;
    switch ($badions[1]) {
        case 'a' :
        case 'O' :
        case 's' :
            if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                return true;
            break;
        case 'b' :
        case 'i' :
        case 'd' :
            if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                return true;
            break;
    }
    return false;
}

/**
 * @param $url
 * @description 从网址获取域名
 */
function findDomainByUrl($url)
{
    preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);

    $host = $matches[2];    // 从主机名中取得后面两段

    preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

    echo "domain name is: {$matches[0]}\n";

}

/**
 * @param $str
 * @param $from
 * @param string $to
 * @return string
 * @description  替换数字符串的里的指定的值
 */
function i_strtr($str, $from, $to = '')
{
    if (is_array($from)) {
        return strtr($str, $from);   //$arr = array("Hello" => "Hi", "world" => "earth");echo strtr("Hello world",$arr);
    } else {
        return strtr($str, $from, $to);   //echo strtr("Hilla Warld","ia","eo");  Hello World
    }
}

/**
 * @param $str
 * @param int $num
 * @param string $symbol
 * @return string
 * @description 切割字符串
 */
function i_chunk_split($str, $num = 1, $symbol = '.')
{
    $str = chunk_split($str, $num, $symbol);
    return $str;
}

/**
 * @param $string
 * @return mixed
 * 简单的函数删除评论从字符串
 */
function remove_comments(& $string)
{
    $string = preg_replace("%(#|;|(//)).*%", "", $string);
    $string = preg_replace("%/\*(?:(?!\*/).)*\*/%s", "", $string); // google for negative lookahead
    return $string;
}

/**
 * @description: 返回文件的信息
 * @time: 2018年6月3日23:05:28
 * @Author: yfl
 * @QQ 554665488
 * @param $filePath
 * @return mixed
 */
function filePathToArr($filePath)
{
    $arr = pathinfo($filePath);
    return $arr;//Array([dirname] => /testweb ,[basename] => test.txt ,[extension] => txt,'filename')
}

/**
 * @description:格式化时间
 * @time: 2018年6月3日23:54:19
 * @Author: yfl
 * @QQ 554665488
 * @param $time
 * @return false|string
 */
function getDateTime($time = 0)
{
    $time = $time == 0 ? time() : $time;
    return date('Y-m-d H:i:s', $time);
}


