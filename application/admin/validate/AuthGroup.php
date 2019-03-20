<?php

namespace app\admin\validate;

use \think\Validate;

/**
 * 规则
 */
class AuthGroup extends Validate
{
    //验证规则
    protected $rule = [
        'title' => ['require'],
        'rules' => ['require'],
    ];

    //提示信息
    protected $message = [
        'title' => '名称必填',
        'rules' => '选择权限',
    ];


}
