<?php

namespace app\admin\logic;

use \think\Model;

/**
 * 管理员登陸日志操作
 */
class LoginLog extends Model
{
    /**获取管理员登陸日志列表
     * @return mixed
     */
    public function getLists($uid = '', $userName = '', $loginIp = '', $startTime = '', $endTime = '', $myorder = 'a.id desc', $page = 1, $psize = 10)
    {
        return my_model('LoginLog', 'model', 'admin')->getLists($uid, $userName, $loginIp, $startTime, $endTime, $myorder, $page, $psize);
    }

    /**获取管理员登陸日志数量
     * @return mixed
     */
    public function getTotal($uid = '', $userName = '', $loginIp = '', $startTime = '', $endTime = '')
    {
        return my_model('LoginLog', 'model', 'admin')->getTotal($uid, $userName, $loginIp, $startTime, $endTime);
    }


}
