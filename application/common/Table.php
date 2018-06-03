<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-5-26
 * Time: 23:04
 */

namespace app\common;
use think\Db;

class Table
{
    /**
     * 通用分页查询
     *
     * @param  array  $where 查询条件默认为  1 = 1(查询所有)
     * @return array  查询结果集
     */
    public function getTablePage($table ,$where = '1 = 1', $page = 1, $count = 10)
    {
        try {
            return Db::name($table)
                ->where($where)
                ->page($page, $count)
                ->select();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 通用根据表查询
     *
     * @param  array  $where 查询条件默认为  1 = 1(查询所有)
     * @return array  查询单条数据
     */
    public function getTable($table ,$where = '1 = 1', $flag = false)
    {
        try {
            if ($flag) {
                return Db::name($table)
                    ->where($where)
                    ->find();
            }
            return Db::name($table)
                ->where($where)
                ->select();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 通用根据表查询查询返回需要的字段
     *
     * @param  array  $where 查询条件默认为  1 = 1(查询所有)
     * @return array         查询结果
     */
    public function getTableField($table ,$where = '1 = 1', $field = '', $flag = false)
    {
        try {
            if ($flag) {
                return Db::name($table)
                    ->where($where)
                    ->field($field)
                    ->find();
            }
            return Db::name($table)
                ->where($where)
                ->field($field)
                ->select();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 数据需要排序时
     *
     * @param  string       $table 表名
     * @param  array|string $where 查询条件
     * @param  string       $order 排序条件
     * @param  string       $way   排序方式
     * @param  boolean      $flag  判断是否单条查询 默认select()方式查询
     * @return
     */
    public function getTableOrder($table, $where = '1 = 1', $order, $way = 'asc', $flag = true)
    {
        try {
            if ($flag) {
                return Db::name($table)
                    ->where($where)
                    ->order($order, $way)
                    ->select();
            }
            return Db::name($table)
                ->where($where)
                ->order($order, $way)
                ->find();
        } catch (\Exception $e) {
            return null;
        }
    }

    /** *
     * @description:通用查询查询总条数
     * @time: 2018年5月29日21:24:45
     * @Author: yfl
     * @QQ 554665488
     * @param $table
     * @param string $where * @param array $where 查询的条件
     * @return int|string
     */
    public function getCount($table, $where = '1 = 1')
    {
        try {
            return Db::name($table)->where($where)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * 通用给表格新增
     *
     * @param  string  $table 表名
     * @param  array   $data  数据
     * @param  boolean $flag  判断是否批量新增 默认单条
     * @return int            影响数据的条数
     */
    public function insertTable($table, $data, $flag = false)
    {
        try {
            if ($flag) {
                return Db::name($table)->insertAll($data);
            }
            return Db::name($table)->insert($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 通用更新数据
     *
     * @param  string       $table 表名
     * @param  array|string $where 条件
     * @param  array        $data  更新的数据
     * @return                     更新结果
     */
    public function updateTable($table, $where = '1 = 1', $data)
    {
        try {
            return Db::name($table)
                ->where($where)
                ->data($data)
                ->update();
        } catch (\Exception $e) {
            return false;
        }
    }

}