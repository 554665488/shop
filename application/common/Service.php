<?php
/**
 * Created by PhpStorm.
 * User: 554665488
 * Date: 2018-6-10
 * Time: 0:50
 * @description:
 * @Author: yfl
 * @QQ 554665488
 */

namespace app\common;


use think\facade\Config;

class Service
{

    /**
     * @description: 使用php设计模式 注册器模式
     * @time: 2018-6-10 00:56:09
     * @Author: yfl
     * @QQ 554665488
     * @param $modelName :模块的名称
     * @param $serviceName :逻辑模型的名字
     * @return object
     */
    public static function access(string $modelName, string $serviceName)
    {
        ## 获取创建的service类的地址  命名空间  并且绑定到容器
        bind($serviceName, Config::get('service.' . $modelName) . $serviceName);
        //快速获取容器中的实例
        return app($serviceName);
    }
}