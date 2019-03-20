<?php

namespace app\admin\logic;

use \think\Model;
use app\common\CommonConstant;
use app\common\util\TreeUtil;

/**
 * 权限操作
 */
class AuthRule extends Model
{

    /**
     * 获取权限组权限
     * @param $groupId 分组id
     * @return array
     */
    public function getAuthByGroupId($groupId)
    {
        $group = my_model('AuthGroup', 'model', 'admin')->getGroupById($groupId);
        if ($group['status'] != 1 || empty($group['rules'])) {
            return [];
        }
        $ruleIds = explode(',', $group['rules']);
        return my_model('AuthRule', 'model', 'admin')->getRuleByIds($ruleIds);
    }

    /**
     * 获取权限组权限 格式化成树状
     * @param $groupId 分组id
     * @return array
     */
    public function getAuthByGroupIdToTree($groupId)
    {
        $group = my_model('AuthGroup', 'model', 'admin')->getGroupById($groupId);
        if ($group['status'] != 1 || empty($group['rules'])) {
            return [];
        }
        $ruleIds = explode(',', $group['rules']);
        $rules   = my_model('AuthRule', 'model', 'admin')->getRuleByIds($ruleIds);
        $rules   = TreeUtil::listToTreeMulti($rules, 0, 'id', 'pid', 'children');
        return $rules;
    }

    /** 根据名称获取权限
     * @param $name 权限标识
     * @param $groupId 分组id
     * @return bool
     */
    public function hasAccessByName($name, $groupId)
    {
        $rule = my_model('AuthRule', 'model', 'admin')->getRuleByName($name);
        if (empty($rule)) {
            return true;
        }
        if ($rule['status'] === 0) {
            return false;
        }
        $group = my_model('AuthGroup', 'model', 'admin')->getGroupById($groupId);
        if ($group['status'] != 1 || empty($group['rules'])) {
            return false;
        }
        $myRuleIds = explode(',', $group['rules']);
        if (in_array($rule['id'], $myRuleIds)) {
            return true;
        } else {
            return false;
        }
    }

    /** 通过ID获取信息
     * @param $id
     */
    public function getRuleById($id)
    {
        return my_model('AuthRule', 'model', 'admin')->getRuleById($id);
    }

    /** 通过标识获取信息
     * @param $name
     * @return mixed
     */
    public function getRuleByName($name)
    {
        return my_model('AuthRule', 'model', 'admin')->getRuleByName($name);
    }

    /**
     * 获取列表
     */
    public function getLists($title = '', $status = -1, $myorder = 'a.id desc')
    {
        return my_model('AuthRule', 'model', 'admin')->getLists($title, $status, $myorder);
    }

    /**
     * 获取所有的列表,不分页
     */
    public function getListsAll($status = -1, $myorder = 'a.id desc')
    {
        return my_model('AuthRule', 'model', 'admin')->getListsAll($status, $myorder);
    }

    /**
     * 获取数量
     */
    public function getTotal($title = '', $status = -1)
    {
        return my_model('AuthRule', 'model', 'admin')->getTotal($title, $status);
    }

    /** 保存
     * @param $id
     * @param $data
     */
    public function modify($id, $data)
    {
        $data['updateTime'] = time();
        if ($id) {
            if (my_model('AuthRule', 'model', 'admin')->check($data['name']) && $id != my_model('AuthRule', 'model', 'admin')->check($data['name'])) {
                ajax_return_error('该标识已存在!');
            }
            return my_model('AuthRule', 'model', 'admin')->modify($id, $data);
        } else {
            if (my_model('AuthRule', 'model', 'admin')->check($data['name'])) {
                ajax_return_error('该标识已存在!');
            }
            return my_model('AuthRule', 'model', 'admin')->add($data);
        }
    }

    /** 删除
     * @param $id
     * @return int
     */
    public function del($id)
    {
        $info = my_model('AuthRule', 'model', 'admin')->getRuleByPid($id);
        if ($info) {
            ajax_return_error('请先删除下级!');
        }
        return my_model('AuthRule', 'model', 'admin')->del($id);
    }

    /**
     * @param $val id 值
     * @param $field 修改字段
     * @param $value 字段值
     */
    public function change($val, $field, $value)
    {
        $table = 'auth_rule';
        $id    = 'id';
        return model('Admin')->change($table, $id, $val, $field, $value);
    }

    public function sort($listOrder)
    {
        if (empty($listOrder)) {
            ajax_return_error('没有数据！');
        } else {

            foreach ($listOrder as $id => $sorts) {
                my_model('AuthRule', 'model', 'admin')->sort($id, $sorts);
            }
            return true;
        }
    }

}
