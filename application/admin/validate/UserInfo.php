<?php

namespace app\admin\validate;

use \think\Validate;

/**
 * 管理员
 */
class UserInfo extends Validate
{
    //验证规则
    protected $rule = [
        'user_name' => ['require', 'max' => '25'],
        'password' => ['require'],
        'tel_phone'    => ['regex' => '/1[3458]{1}\d{9}$/'],
        'email'    => ['email'],
    ];

    //提示信息
    protected $message = [
        'user_name.require' => '账号必须',
        'user_name.max'     => '账号最多不能超过25个字符',
        'password'         => '密码必须',
        'tel_phone.regex'      => '手机格式错误',
        'email'            => '邮箱格式错误',
    ];

    //验证场景
    protected $scene = [
        'add' => ['user_name', 'password','tel_phone','email'],
        'save'  => ['userName', 'groupId', 'phone', 'email'],
        'modify'  => ['phone', 'email'],
    ];


}
