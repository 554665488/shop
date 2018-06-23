<?php

\think\Facade::bind([
    'app\common\facade\SCFacade' => 'app\common\SC', //session

]);
//类的映射
\think\Loader::addClassAlias([
    'SC' => 'app\common\facade\SCFacade',
]);