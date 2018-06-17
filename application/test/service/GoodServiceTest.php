<?php
namespace app\test\service;

use app\model\GoodsCategory;
use app\model\Goods;
use app\model\Shop;
use app\model\AlbumPicture;
/**
 *
 */
class GoodServiceTest
{
    public function getGoodsList($page_index = 1, $page_size = 20, $data = [])
    {
        return Goods::with('albumPicture')->page($page_index, $page_size)->select();
    }
}
