<?php

namespace app\admin\controller;

use app\common\controller\Api;
use app\common\util\AuthUtil;

/**
 * 后台登陆
 * @author hardphp@163.com
 */
class Login extends Api
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 登录
     */
    public function index()
    {
        if ($this->request->isPost()) {
            //接收数据
            $data     = [
                'userName' => input('userName', '', 'trim'),
                'password' => input('password', '', 'trim'),
                //'verify'   => input('verify', '', 'trim')
            ];
            $validate = validate('Admin');
            $result   = $validate->scene('login')->check($data);
            if (!$result) {
                $error = $validate->getError();
                ajax_return_error($error);
            }
            // 登录验证并获取包含访问令牌的用户
            $result = model('Admin', 'logic')->login($data['userName'], $data['password']);
            ajax_return_ok($result, '登录成功');
        }
    }


}
