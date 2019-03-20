<?php

namespace app\user\model;

use think\Model;
use think\Db;

/**
 * Class user 会员管理
 * xiegaolei
 * @package app\user\model
 */
class User extends Model
{

    /** 通过ID获取信息
     * @param $id
     */
    public function getUserById($id)
    {
        $where = " a.isDel = 0 and a.id = " . $id;
        return Db::name('user')->alias('a')->field('a.*')->where($where)->find();
    }

    /** 通过手机号获取信息
     * @param $phone
     */
    public function getUserByPhone($phone)
    {
        $where = " a.isDel = 0 and a.phone = " . $phone;
        return Db::name('user')->alias('a')->field('a.*')->where($where)->find();
    }

    /** 通过用户名获取信息
     * @param $name
     */
    public function getUserByName($name)
    {
        $where = " a.isDel = 0 and a.userName = " . $name;
        return Db::name('user')->alias('a')->field('a.*')->where($where)->find();
    }

    /**
     * 获取列表
     */
    public function getLists($userName, $nickName, $phone, $adzoneId, $realName, $openId, $startTime, $endTime, $isEnabled, $pid, $myorder, $page, $psize)
    {
        $where = 'a.isDel = 0';
        if ($userName) {
            $where .= " and a.userName = '" . $userName . "' ";
        }

        if ($nickName != '') {
            $where .= " and a.nickName =  '" . $nickName . "'";
        }

        if ($adzoneId != '') {
            $where .= " and a.adzoneId =  '" . $adzoneId . "'";
        }

        if ($realName != '') {
            $where .= " and a.realName =  '" . $realName . "'";
        }

        if ($phone != '') {
            $where .= " and a.phone =  '" . $phone . "'";
        }
        if ($openId != '') {
            $where .= " and a.openId =  '" . $openId . "'";
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
        if ($pid != '') {
            $where .= " and (a.pid =  " . $pid . " or a.pid2 = " . $pid . ")";
        }
        return Db::name('user')->alias('a')->field('a.*')->where($where)->order($myorder)->page($page, $psize)->select();
    }


    /**
     * 获取数量
     */
    public function getTotal($userName, $nickName, $phone, $adzoneId, $realName, $openId, $startTime, $endTime, $isEnabled, $pid)
    {
        $where = 'a.isDel = 0';
        if ($userName) {
            $where .= " and a.userName = '" . $userName . "' ";
        }

        if ($nickName != '') {
            $where .= " and a.nickName =  '" . $nickName . "'";
        }

        if ($adzoneId != '') {
            $where .= " and a.adzoneId =  '" . $adzoneId . "'";
        }

        if ($realName != '') {
            $where .= " and a.realName =  '" . $realName . "'";
        }

        if ($phone != '') {
            $where .= " and a.phone =  '" . $phone . "'";
        }
        if ($openId != '') {
            $where .= " and a.openId =  '" . $openId . "'";
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
        if ($pid != '') {
            $where .= " and (a.pid =  " . $pid . " or a.pid2 = " . $pid . ")";
        }
        return Db::name('user')->alias('a')->field('a.*')->where($where)->count();
    }

    /**
     * [check 检测是否存在]
     * @param  [type] $orderNum
     * @return [type]
     */
    public function check($phone)
    {
        $id = Db::name('user')->where(['phone' => $phone, 'isDel' => 0])->value('id');
        if (empty($id)) {
            return 0;
        } else {
            return $id;
        }
    }

    /**新增
     * @param $data
     */
    public function add($data)
    {
        return Db::name('user')->insertGetId($data);
    }

    /** 更新
     * @param array $id
     * @param array $data
     * @return $this|void
     */
    public function modify($id, $data)
    {
        return Db::name('user')->where(['id' => $id])->update($data);
    }


}