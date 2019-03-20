<?php

namespace app\user\validate;

use \think\Validate;

/**
 * 用户校验
 */
class User extends Validate
{
    //验证规则
    protected $rule = [
        'userName' => ['require', 'length' => '6,20', 'alphaNum'],
        'realName' => ['require'],
        'phone'    => ['regex' => '/1[3458]{1}\d{9}$/'],
        'password' => ['require', 'length' => '6,20', 'alphaNum'],
        'code'     => ['require', 'integer'],
    ];

    //提示信息
    protected $message = [
        'userName.require'  => '账号必须',
        'userName.length'   => '账号长度6-20位',
        'userName.alphaNum' => '账号只能包含字母和数字',
        'realName.require'  => '姓名必须',
        'phone.regex'       => '手机格式错误',
        'password.require'  => '密码必须',
        'password.length'   => '密码长度6-20位',
        'password.alphaNum' => '密码不正确',
        'code.require'      => '验证码必须',
        'code.integer'      => '验证码类型不正确'
    ];

    //验证场景
    protected $scene = [
        'login'  => ['phone', 'password'],
        'login2' => ['userName', 'password'],
        'reg'    => ['phone', 'password', 'code'],
        'reg2'   => ['userName', 'password'],
        'save'   => ['phone']
    ];


}
