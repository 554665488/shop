<?php
/**
 * 排除一些请求的地址配置
 */
return [
    // admin 模块 不需要验证的登录的地址
    'admin'=>[
        'index/login', // 登录方法
//        'index/index', // 登录方法
        'verify/verify', // 验证码
    ],
    // wap端
    'wap'=>[

    ],
    //前台
    'index'=>[

    ]
];