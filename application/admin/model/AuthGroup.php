<?php

namespace app\admin\model;

use \think\Model;
use \think\Db;

/**
 * 用户组相关操作
 */
class AuthGroup extends Model
{
    /** 通过ID获取分组信息
     * @param $groupId 用户组id
     */
    public function getGroupById($groupId)
    {
        $where = ['id' => $groupId];
        return Db::name('auth_group')->where($where)->find();
    }

    /** 获取分组列表
     * @param $title
     * @param $status
     */
    public function getLists($title, $status, $myorder, $page, $psize)
    {
        $where = true;
        if ($title) {
            $where .= " and title like '%" . $title . "%' ";
        }
        if ($status != -1) {
            $where .= " and status = " . $status;
        }
        return Db::name('auth_group')->where($where)->order($myorder)->page($page, $psize)->select();
    }

    /**
     * 获取所有的列表,不分页
     */
    public function getListsAll($status, $myorder)
    {
        $where = true;
        if ($status != -1) {
            $where .= " and a.status =  " . $status;
        }
        return Db::name('auth_group')->alias('a')->field('a.*')->where($where)->order($myorder)->select();
    }

    /** 获取分组数量
     * @param $title
     * @param $status
     */
    public function getTotal($title, $status)
    {
        $where = true;
        if ($title) {
            $where .= " and title like '%" . $title . "%' ";
        }
        if ($status != -1) {
            $where .= " and status = " . $status;
        }
        return Db::name('auth_group')->where($where)->count();
    }

    /** 更新
     * @param array $id
     * @param array $data
     * @return $this|void
     */
    public function modify($id, $data)
    {
        return Db::name('auth_group')->where(['id' => $id])->update($data);
    }

    /**新增
     * @param $data
     */
    public function add($data)
    {
        return Db::name('auth_group')->insertGetId($data);
    }

    /** 删除
     * @param $id
     * @return int
     */
    public function del($id)
    {
        return Db::name('auth_group')->where('id', $id)->delete();
    }

    /** 批量删除
     * @param $ids
     * @return int
     */
    public function delall($ids)
    {
        return Db::name('auth_group')->where('id', 'in',$ids)->delete();
    }

    /**
     * [check 检测是否存在]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function check($name)
    {
        $id = Db::name('auth_group')->where('title', $name)->value('id');
        if (empty($id)) {
            return 0;
        } else {
            return $id;
        }
    }

}
