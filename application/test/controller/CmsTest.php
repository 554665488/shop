<?php
namespace app\test\controller;

use think\Controller;
use app\common\Service;
use app\home\service\CmsService;

class CmsTest extends Controller
{
    public function cmsArticletest()
    {
        $cmsService = new CmsService;
        return json($cmsService->getCmsArticle());
    }
}
