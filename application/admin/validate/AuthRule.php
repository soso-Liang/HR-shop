<?php

namespace app\admin\validate;

use \think\Validate;

/**
 * 规则
 */
class AuthRule extends Validate
{
    //验证规则
    protected $rule = [
        'title'     => ['require'],
        'name'      => ['require'],
        'icon'      => ['require'],
        'path'      => ['require'],
        'component' => ['require'],
    ];

    //提示信息
    protected $message = [
        'title'     => '名称必填',
        'name'      => '标识必填',
        'icon'      => '图标必填',
        'path'      => '路径必填',
        'component' => '组件必填',
    ];


}
