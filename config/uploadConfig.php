<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-10
 * Time: 0:30
 * @description:所有上传目录配置  TODO 代码还有地方没有使用这里的信息  待完善
 * @Author: yfl
 * @QQ 554665488
 */


return [
    // 系统模块图片
    'admin'                 => '\\upload\\admin\\',
    // 存放广告位图片
    'advertising'           => '\\upload\\advertising\\',
    // 存放用户头像
    'avator'                => '\\upload\\avator\\',
    // 存放物流图片
    'express'               => '\\upload\\express\\',
    // 存放商品图片、主图、sku
    'goods'                 => '\\upload\\goods\\',
    // 存放公共图片、网站logo、独立图片、没有任何关联的图片
    'common'                => '\\upload\\common\\',
    // 商品二维码
    'goods_qrcode'          => '\\upload\\goods_qrcode\\',
    // 二维码
    'qrcode'                => '\\upload\\qrcode\\',
];
