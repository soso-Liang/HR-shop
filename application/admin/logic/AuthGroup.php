<?php

namespace app\admin\logic;

use \think\Model;
use app\common\CommonConstant;

/**
 * 分组操作
 */
class AuthGroup extends Model
{

    /** 获取分组列表
     * @param $title
     * @param $status
     */
    public function getLists($title = '', $status = -1, $myorder = 'id desc', $page, $psize)
    {
        return my_model('AuthGroup', 'model', 'admin')->getLists($title, $status, $myorder, $page, $psize);
    }

    /**
     * 获取所有的列表,不分页
     */
    public function getListsAll($status = -1, $myorder = 'a.id asc')
    {
        return my_model('AuthGroup', 'model', 'admin')->getListsAll($status, $myorder);
    }

    /** 通过ID获取信息
     * @param $id
     */
    public function getGroupById($id)
    {
        return my_model('AuthGroup', 'model', 'admin')->getGroupById($id);
    }

    /**
     * 获取数量
     */
    public function getTotal($title = '', $status = -1)
    {
        return my_model('AuthGroup', 'model', 'admin')->getTotal($title, $status);
    }

    /** 保存
     * @param $id
     * @param $data
     */
    public function modify($id, $data)
    {
        $data['updateTime'] = time();
        if ($id) {
            if (my_model('AuthGroup', 'model', 'admin')->check($data['title']) && $id != my_model('AuthGroup', 'model', 'admin')->check($data['title'])) {
                ajax_return_error('该名称已存在!');
            }
            return my_model('AuthGroup', 'model', 'admin')->modify($id, $data);
        } else {
            if (my_model('AuthGroup', 'model', 'admin')->check($data['title'])) {
                ajax_return_error('该名称已存在!');
            }
            return my_model('AuthGroup', 'model', 'admin')->add($data);
        }
    }

    /** 删除
     * @param $id
     * @return int
     */
    public function del($id)
    {
        return my_model('AuthGroup', 'model', 'admin')->del($id);
    }

    /** 批量删除
     * @param $ids
     * @return int
     */
    public function delall($ids)
    {
        return my_model('AuthGroup', 'model', 'admin')->delall($ids);
    }

    /**
     * @param $val id 值
     * @param $field 修改字段
     * @param $value 字段值
     */
    public function change($val, $field, $value)
    {
        $table = 'auth_group';
        $id    = 'id';
        return my_model('Admin', 'model', 'admin')->change($table, $id, $val, $field, $value);
    }
}
