<?php

namespace app\common\logic;

use \think\Model;
use app\common\CommonConstant;
use app\common\util\JwtUtil;

/**
 * 应用相关操作
 */
class App extends Model
{
    /**
     * 登录。
     * 此时客户端的用户认证方式是JWT
     * @param string $appId
     * @param string $appSecret
     * @return array 对象数组，包含字段：accessToken
     * @throws Exception my_error抛出
     */
    public function login($appId, $appSecret)
    {
        $app = model('App')->getAppByAppId($appId);
        if (empty($app)) {
            my_exception('', CommonConstant::e_app_miss);
        }
        //密码验证
        if ($app['appSecret'] !== encrypt_pass($appId)) {
            my_exception('', CommonConstant::e_app_pass_wrong);
        }
        // 检测用户状态
        if ($app ['isEnabled'] != CommonConstant::db_true) {
            my_exception('', CommonConstant::e_app_disabled);
        }
        // 令牌获取
        $time = time();
        model('App')->modify($app['id'], ['loginTime' => $time, 'loginIp' => request()->ip()]);
        // 令牌生成
        $payload['appId']     = $appId;
        $payload['loginTime'] = $time;
        $accessToken          = think_encrypt(JwtUtil::encode($payload));
        // 返回
        return array('accessToken' => $accessToken);
    }


}
