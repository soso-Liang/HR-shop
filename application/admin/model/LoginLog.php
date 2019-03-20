<?php

namespace app\admin\model;

use \think\Model;
use \think\Db;

/**
 * 管理员登陆日志
 */
class LoginLog extends Model
{
    /**
     * 获取管理员登陸日志列表
     */
    public function getLists($uid, $userName, $loginIp, $startTime, $endTime, $myorder, $page, $psize)
    {
        $where = true;
        if ($uid) {
            $where .= " and a.uid = " . $uid . " ";
        }
        if ($userName) {
            $where .= " and  a.userName like '%" . $userName . "%' ";
        }
        if ($loginIp) {
            $where .= " and  a.loginIp = '" . $loginIp . "' ";
        }
        if ($startTime) {
            $where .= " and  a.loginTime >= " . $startTime . " ";
        }
        if ($endTime) {
            $where .= " and  a.loginTime <= " . $endTime . " ";
        }
        return Db::name('login_log')->alias('a')->field('a.*')->where($where)->order($myorder)->page($page, $psize)->select();
    }

    /** 查询管理员登陸日志数量
     * @param $keyword
     * @param $isEnabled
     */
    public function getTotal($uid, $userName, $loginIp, $startTime, $endTime)
    {
        $where = true;
        if ($uid) {
            $where .= " and a.uid = " . $uid . " ";
        }
        if ($userName) {
            $where .= " and  a.userName like '%" . $userName . "%' ";
        }
        if ($loginIp) {
            $where .= " and  a.loginIp = '" . $loginIp . "' ";
        }
        if ($startTime) {
            $where .= " and  a.loginTime >= " . $startTime . " ";
        }
        if ($endTime) {
            $where .= " and  a.loginTime <= " . $endTime . " ";
        }
        return Db::name('login_log')->alias('a')->where($where)->count();
    }

    /** 添加日志
     * @param $data
     */
    public function add($data)
    {
        return Db::name('login_log')->insertGetId($data);
    }


}
