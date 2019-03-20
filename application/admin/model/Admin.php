<?php

namespace app\admin\model;

use \think\Model;
use \think\Db;

/**
 * 管理员相关操作
 */
class Admin extends Model
{
    /** 通过ID获取用户信息
     * @param $uid 用户id
     */
    public function getAdminById($uid)
    {
        $where = " a.id = " . $uid;
        $user  = Db::name('admin')->alias('a')->field('a.*,b.title')->join('auth_group b', 'a.groupId = b.id', 'left')->where($where)->find();
        return $user;
    }

    /** 通过用户名获取用户信息
     * @param $userName 用户名
     */
    public function getAdminByName($userName)
    {
        $where = ['userName' => $userName];
        $user  = Db::name('admin')->alias('a')->field('a.*,b.title')->join('auth_group b', 'a.groupId = b.id', 'left')->where($where)->find();
        return $user;
    }

    /**
     * 获取管理员列表
     */
    public function getLists($userName, $phone, $realName, $startTime, $endTime, $isEnabled, $myorder, $page, $psize)
    {
        $where = true;
        if ($userName) {
            $where .= " and a.userName like '%" . $userName . "%' ";
        }
        if ($phone) {
            $where .= " and  a.phone like '%" . $phone . "%' ";
        }
        if ($realName) {
            $where .= " and  a.realName like '%" . $realName . "%' ";
        }
        if ($startTime) {
            $where .= " and  a.loginTime >= " . $startTime . " ";
        }
        if ($endTime) {
            $where .= " and  a.loginTime <= " . $endTime . " ";
        }
        if ($isEnabled != -1) {
            $where .= " and a.isEnabled =  " . $isEnabled;
        }
        return Db::name('admin')->alias('a')->field('a.*,b.title')->join('auth_group b', 'a.groupId = b.id', 'left')->where($where)->order($myorder)->page($page, $psize)->select();
    }

    /** 查询管理员得数量
     * @param $keyword
     * @param $isEnabled
     */
    public function getTotal($userName, $phone, $realName, $startTime, $endTime, $isEnabled)
    {
        $where = true;
        if ($userName) {
            $where .= " and a.userName like '%" . $userName . "%' ";
        }
        if ($phone) {
            $where .= " and  a.phone like '%" . $phone . "%' ";
        }
        if ($realName) {
            $where .= " and  a.realName like '%" . $realName . "%' ";
        }
        if ($startTime) {
            $where .= " and  a.loginTime >= " . $startTime . " ";
        }
        if ($endTime) {
            $where .= " and  a.loginTime <= " . $endTime . " ";
        }
        if ($isEnabled != -1) {
            $where .= " and a.isEnabled =  " . $isEnabled;
        }
        return Db::name('admin')->alias('a')->join('auth_group b', 'a.groupId = b.id', 'left')->where($where)->count();
    }

    /** 更新
     * @param array $uid
     * @param array $data
     * @return $this|void
     */
    public function modify($uid, $data)
    {
        return Db::name('admin')->where(['id' => $uid])->update($data);
    }

    /**新增
     * @param $data
     */
    public function add($data)
    {
        return Db::name('admin')->insertGetId($data);
    }

    /** 删除
     * @param $uid
     * @return int
     */
    public function del($uid)
    {
        return Db::name('admin')->where('id', $uid)->delete();
    }

    /** 批量删除
     * @param $uids
     * @return int
     */
    public function delall($uids)
    {
        return Db::name('admin')->where('id', 'in',$uids)->delete();
    }

    /**
     * [checkAdmin 检测用户名是否存在]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function checkAdmin($name)
    {
        $id = Db::name('admin')->where('userName', $name)->value('id');
        if (empty($id)) {
            return 0;
        } else {
            return $id;
        }
    }

    /**获取密码
     * @param $uid
     */
    public function getPwd($uid)
    {
        return Db::name('admin')->where('id', $uid)->value('password');
    }

    /**设置密码
     * @param $uid
     */
    public function setPwd($uid, $newPwd)
    {
        return Db::name('admin')->where('id', $uid)->setField('password', $newPwd);
    }

    /**
     * @param $val id 值
     * @param $field 修改字段
     * @param $value 字段值
     */
    public function change($table, $id, $val, $field, $value)
    {
        return Db::name($table)->where($id, $val)->update([$field => $value,'updateTime'=>time()]);
    }

}
