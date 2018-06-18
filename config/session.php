<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 会话设置
// +----------------------------------------------------------------------

return [
    'id' => '',//session_id
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',//请求session_id变量名
    // SESSION 前缀
    'prefix' => 'think',
    // 驱动方式 支持redis memcache memcached
    'type' => '',
    // 是否自动开启 SESSION
    'auto_start' => true,
//    'use_trans_sid' => false,//是否使用use_trans_sid
//    'name' => '', //session_name
//    'path' => '',//session保存路径
//    'domain' => '',//session cookie_domain
//    'use_cookies' => '',//是否使用cookie
//    'cache_limiter' => '',//session_cache_limiter
//    'cache_expire' => '',//session_cache_expire
//    'httponly' => '',//使用httponly
];
