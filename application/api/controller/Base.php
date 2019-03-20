<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\util\AuthUtil;

/**
 * api基类 -- 不验证用户登录
 * @author hardphp@163.com
 *
 */
class Base extends Api
{
    public function _initialize()
    {
        parent::_initialize();
    }


}
