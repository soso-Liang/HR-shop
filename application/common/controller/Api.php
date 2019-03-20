<?php

namespace app\common\controller;

use app\common\util\AuthUtil;
use Think\Log;

/**
 * 接口基类
 * @author hardphp@163.com
 */
class Api extends \think\Controller
{
    public function _initialize()
    {
        //跨域访问
        if (config('app_debug') == true) {
            header("Access-Control-Allow-Origin:*");
            // 响应类型
            header("Access-Control-Allow-Methods:GET,POST");
            // 响应头设置
            header("Access-Control-Allow-Headers:x-requested-with,content-type,x-access-token,x-access-appid");
        }
        //签名验证
        AuthUtil::checkSign();

    }

}
