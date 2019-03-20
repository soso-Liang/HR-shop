<?php

namespace app\api\controller;
/**
 * 登陆
 * @author hardphp@163.com
 */
class Login extends Base
{
    /**
     * 手机号登录
     */
    public function index()
    {
        if ($this->request->isPost()) {
            //接收数据
            $data     = [
                'phone'    => input('phone', '', 'trim'),
                'password' => input('password', '', 'trim')
            ];
            $validate = my_validate('User', 'user');
            $result   = $validate->scene('login')->check($data);
            if (!$result) {
                $error = $validate->getError();
                ajax_return_error($error);
            }
            // 登录验证并获取包含访问令牌的用户
            $result = my_model('User', 'logic', 'user')->login($data['userName'], $data['password'], 1);
            ajax_return_ok($result, '登录成功');
        }
    }

    /**
     * 账号登录
     */
    public function index2()
    {
        if ($this->request->isPost()) {
            //接收数据
            $data     = [
                'userName' => input('userName', '', 'trim'),
                'password' => input('password', '', 'trim'),
            ];
            $validate = my_validate('User', 'user');
            $result   = $validate->scene('login2')->check($data);
            if (!$result) {
                $error = $validate->getError();
                ajax_return_error($error);
            }
            // 登录验证并获取包含访问令牌的用户
            $result = my_model('User', 'logic', 'user')->login($data['userName'], $data['password'], 2);
            ajax_return_ok($result, '登录成功');
        }
    }


}
