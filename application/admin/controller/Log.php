<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use \think\Db;

/**
 * 管理员登录日志管理
 * @author hardphp@163.com
 */
class Log extends Base
{
    /**
     * 列表
     */
    public function index()
    {
        if ($this->request->isPost()) {
            //搜索参数
            $userName  = input('userName', '', 'trim');
            $uid       = input('uid', '', 'trim');
            $loginIp   = input('loginIp', '', 'trim');
            $startTime = input('startTime', '', 'strtotime');
            $endTime   = input('endTime', '', 'strtotime');
            $order     = input('order/a', 'a.id desc');
            $page      = input('page', 1, 'intval');
            $psize     = input('psize', 10, 'intval');

            $lists           = model('LoginLog', 'logic')->getLists($uid, $userName, $loginIp, $startTime, $endTime, $order, $page, $psize);
            $result['total'] = model('LoginLog', 'logic')->getTotal($uid, $userName, $loginIp, $startTime, $endTime);
            $result['data']  = $lists;
            ajax_return_ok($result);
        }
    }

}
