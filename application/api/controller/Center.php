<?php

namespace app\api\controller;

use app\common\util\AuthUtil;

/**
 * 会员基类 --验证登录
 * @author hardphp@163.com
 *
 */
class Center extends Base
{
    //用户信息
    protected $user = [];
    protected $uid = 0;

    public function _initialize()
    {
        parent::_initialize();
        //身份验证
        $result = AuthUtil::checkUser('user');
        if ($result['status']) {
            $this->user = $result['msg'];
            $this->uid  = $result['msg']['id'];
        }
    }


}
