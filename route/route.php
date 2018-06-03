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

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

Route::get('verify', 'admin/verify/verify');
//后台路由组
Route::group('admin', function () {
    Route::rule('Aindex','admin/index/index');
    Route::rule('login','admin/index/login');
    Route::rule('goodslist','admin/goods/goodslist');
});


//后台路动态由组
//Route::group('admin', function () {
//    Route::rule('index/:action', 'admin/index/:action');
//    Route::rule('goods/:action', 'admin/goods/:action');
//});
return [
//    '__pattern__' => [
//       'controller'=>'/^[A-Za-z0-9]+$/',
//       'action'=>'/^[A-Za-z0-9]+$/',
//    ]
];

