<?php

namespace app\common\validate;

use \think\Validate;

/**
 * 应用
 */
class App extends Validate
{
    //验证规则
    protected $rule = [
        'appId'     => ['require', 'length' => '18', 'alphaNum'],
        'appSecret' => ['require', 'length' => '32', 'alphaNum'],
    ];

    //提示信息
    protected $message = [
        'appId.require'      => 'appId必须',
        'appId.length'       => 'appId不正确',
        'appId.alphaNum'     => 'appId不正确',
        'appSecret.require'  => 'appSecret必须',
        'appSecret.length'   => 'appSecret不正确',
        'appSecret.alphaNum' => 'appSecret不正确',
    ];

    //验证场景
    protected $scene = [
        'login' => ['appId', 'appSecret'],
    ];


}
