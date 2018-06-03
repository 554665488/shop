<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-26
 * Time: 21:01
 */

namespace app\common;

/**
 * @description:无限极分类
 * @time: 2018年5月26日21:02:03
 * @Author: yfl
 * @QQ 554665488
 * Class Tree
 * @package app\common
 */
class Tree
{
    /**
     * @QQ  * @description: 递归转换数据集
     * @time: 2018年5月26日21:08:023
     * @Author: yfl
     * @QQ 554665488
     * @param array $list
     * @param string $pk :自增字段id
     * @param string $pid 父级id
     * @param string $child :子节点key
     * @param int $root 根节点
     * @param int $level 级别
     * @return array
     */
    public function recursiveMakeTree($list, $pk = 'pk_id', $pid = 'pid', $child = '_child', $root = 0,$level=1)
    {
        $tree = [];
        foreach ($list as $index => $item) {
            if ($item[$pid] == $root) {
                $item['level']=$level;
                $tree[$index] = $item;
                $tree[$index][$child] =self::recursiveMakeTree($list, $pk, $pid, $child, $item[$pk],$level+1);
            }
        }
        return $tree;
    }
}