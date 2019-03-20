<?php

namespace app\user\logic;

use think\Model;
use think\Db;
use app\common\CommonConstant;
use app\common\util\JwtUtil;

/**
 * Class user 会员管理
 * xiegaolei
 * @package app\user\model
 */
class User extends Model
{

    /** 通过ID获取信息
     * @param $id
     */
    public function getUserById($id)
    {
        return my_model('User', 'model', 'user')->getUserById($id);
    }

    /**
     * 获取列表
     */
    public function getLists($userName = '', $nickName = '', $phone = '', $adzoneId = '', $realName = '', $openId = '', $startTime = '', $endTime = '', $isEnabled = -1, $pid = '', $myorder = 'a.id desc', $page = 1, $psize = 10)
    {
        return my_model('User', 'model', 'user')->getLists($userName, $nickName, $phone, $adzoneId, $realName, $openId, $startTime, $endTime, $isEnabled, $pid, $myorder, $page, $psize);
    }

    /**
     * 获取数量
     */
    public function getTotal($userName = '', $nickName = '', $phone = '', $adzoneId = '', $realName = '', $openId = '', $startTime = '', $endTime = '', $isEnabled = -1, $pid = '')
    {
        return my_model('User', 'model', 'user')->getTotal($userName, $nickName, $phone, $adzoneId, $realName, $openId, $startTime, $endTime, $isEnabled, $pid);
    }

    /** 保存
     * @param $id
     * @param $data
     */
    public function modify($id, $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = encrypt_pass($data['password']);
        }

        if ($id) {
            $data['updateTime'] = time();
            unset($data['regTime']);
            if (my_model('User', 'model', 'user')->check($data['phone']) && $id != my_model('User', 'model', 'user')->check($data['phone'])) {
                ajax_return_error('该手机号已存在!');
            }
            return my_model('User', 'model', 'user')->modify($id, $data);
        } else {
            $data['regIp'] = request()->ip();
            if (my_model('User', 'model', 'user')->check($data['phone'])) {
                ajax_return_error('该手机号已存在!');
            }
            return my_model('User', 'model', 'user')->add($data);
        }
    }

    /** 修改状态
     * @param $val id 值
     * @param $field 修改字段
     * @param $value 字段值
     */
    public function change($val, $field, $value)
    {
        $table = 'user';
        $id    = 'id';
        return my_model('Admin', 'model', 'admin')->change($table, $id, $val, $field, $value);
    }

    /**  删除
     * @param $id id
     */
    public function del($id)
    {
        return my_model('User', 'model', 'user')->modify($id, ['isDel' => 1, 'updateTime' => time()]);
    }

    /** 批量删除
     * @param $ids
     * @return int
     */
    public function delall($ids)
    {
        return my_model('User', 'model', 'user')->modify($ids, ['isDel' => 1, 'updateTime' => time()]);
    }


    /**
     * 登录。
     * 此时客户端的用户认证方式是JWT
     * @param string $userName
     * @param string $password
     * @param string $type 1 手机号 ，2用户名
     * @return array 对象数组
     * @throws Exception my_error抛出
     */
    public function login($userName, $password, $type = 1)
    {
        if ($type == 1) {
            $user = my_model('User', 'model', 'user')->getUserByPhone($userName);
        } elseif ($type == 2) {
            $user = my_model('User', 'model', 'user')->getUserByName($userName);
        } else {
            my_exception('', CommonConstant::e_api_user_login_type);
        }
        if (empty($user)) {
            my_exception('', CommonConstant::e_user_miss);
        }
        //密码验证
        if ($user['password'] !== encrypt_pass($password)) {
            my_exception('', CommonConstant::e_user_pass_wrong);
        }
        // 检测用户状态
        if ($user ['isEnabled'] != CommonConstant::db_true) {
            my_exception('', CommonConstant::e_user_disabled);
        }
        // 令牌获取
        $time = time();
        my_model('User', 'model', 'user')->modify($user['id'], ['loginTime' => $time, 'loginIp' => request()->ip()]);
        // 令牌生成
        $payload['uid']       = $user['id'];
        $payload['loginTime'] = $time;
        $userToken            = think_encrypt(JwtUtil::encode($payload));
        // 返回
        return array('userToken' => $userToken, 'adzoneId' => $user['adzoneId']);
    }


}