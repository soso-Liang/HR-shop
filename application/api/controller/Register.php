<?php

namespace app\api\controller;

/**
 * 注册
 * @author hardphp@163.com
 * 2018-06-21
 */
class Register extends Base
{
    /**
     * 手机号注册
     */
    public function index()
    {
        if ($this->request->isPost()) {
            //接收数据
            $data     = [
                'phone'    => input('phone', '', 'trim'),
                'password' => input('password', '', 'trim'),
                'code'     => input('code', '', 'int'),
            ];
            $validate = my_validate('User', 'user');
            $result   = $validate->scene('reg')->check($data);
            if (!$result) {
                $error = $validate->getError();
                ajax_return_error($error);
            }
            //验证码
            model('PhoneCode')->checkCode($data['phone'], $data['code'], 1);
            //注册
            $result = my_model('User', 'logic', 'user')->reg($data['phone'], $data['password'], 1);
            ajax_return_ok([], '注册成功');
        }
    }

    /**
     * 账号注册
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
            $result   = $validate->scene('reg2')->check($data);
            if (!$result) {
                $error = $validate->getError();
                ajax_return_error($error);
            }
            //验证码
            model('PhoneCode')->checkCode($data['phone'], $data['code'], 1);
            //注册
            $result = my_model('User', 'logic', 'user')->reg($data['phone'], $data['password'], 2);
            ajax_return_ok([], '注册成功');
        }
    }

}
