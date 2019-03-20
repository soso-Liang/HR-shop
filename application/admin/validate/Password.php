<?php

namespace app\admin\validate;

use \think\Validate;

/**
 * 密码修改
 */
class Password extends Validate
{
    //验证规则
    protected $rule = [
        'oldPwd'  => 'require',
        'newPwd'  => 'require',
        'newPwd'  => 'length:6,10',
        'newPwd2' => 'require|confirm:newPwd',
    ];

    //提示信息
    protected $message = [
        'oldPwd'          => '原始密码必填',
        'newPwd'          => '新密码必填',
        'newPwd.length'   => '密码长度为6到10位',
        'newPwd2'         => '确认密码必填',
        'newPwd2.confirm' => '新密码不相等',
    ];


}
