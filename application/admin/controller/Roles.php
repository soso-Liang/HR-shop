<?php

namespace app\admin\controller;

use app\admin\controller\System;
use \think\Db;
use app\common\util\TreeUtil;

/**
 * 角色管理
 * @author hardphp@163.com
 */
class Roles extends Base
{
    /**
     * 列表
     */
    public function index()
    {
        if ($this->request->isPost()) {
            //搜索参数
            $title  = input('title', '', 'trim');
            $status = input('status', -1, 'int');
            $order  = input('order/a', '');
            $page   = input('page', 1, 'intval');
            $psize  = input('psize', 10, 'intval');

            $lists           = model('AuthGroup', 'logic')->getLists($title, $status, $order, $page, $psize);
            $result['total'] = model('AuthGroup', 'logic')->getTotal($title, $status);
            $result['data']  = $lists;
            ajax_return_ok($result);
        }
    }

    /**
     * 列表,不分页
     */
    public function getLists()
    {
        if ($this->request->isPost()) {
            $lists = model('AuthGroup', 'logic')->getListsAll(1);
            ajax_return_ok($lists);
        }
    }


    /** 详情
     * @return mixed
     */
    public function getinfo()
    {
        $id = input('id', '0', 'int');
        if ($id == 0) {
            ajax_return_error('参数有误！');
        }
        $info          = model('AuthGroup', 'logic')->getGroupById($id);
        ajax_return_ok($info);
    }

    /**
     * 保存
     */
    public function save()
    {
        $id = input('id', '0', 'int');
        //接收数据
        $data     = [
            'title'  => input('title', '', 'trim'),
            'status' => input('status', 0, 'int'),
            'rules'  => input('rules/a', '')
        ];
        $validate = validate('AuthGroup');
        $result   = $validate->check($data);
        if (!$result) {
            $error = $validate->getError();
            ajax_return_error($error);
        }
        $data['rules'] = implode(',', $data['rules']);
        $res           = model('AuthGroup', 'logic')->modify($id, $data);
        if ($res == false) {
            ajax_return_error('保存失败！');
        } else {
            ajax_return_ok(['id' => $res], '保存成功！');
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        $id = input('id', '0', 'int');
        if ($id == 0) {
            ajax_return_error('参数有误！');
        } else {
            if ($id == 1) {
                ajax_return_error('该记录不能删除！');
            }
            if (model('AuthGroup', 'logic')->del($id)) {
                ajax_return_ok([], '删除成功！');
            } else {
                ajax_return_error('删除失败！');
            }
        }
    }

    /**
     * 批量删除
     */
    public function delall()
    {
        $ids = input('ids', '', 'trim');
        if (empty($ids)) {
            ajax_return_error('参数有误！');
        } else {
            $ids = explode(',', $ids);
            $ids = array_diff($ids, [1]);
            model('AuthGroup', 'logic')->delall($ids);
            ajax_return_ok([], '删除成功！');
        }
    }

    public function change()
    {

        $val   = input('val', '', 'int');
        $field = input('field', '', 'trim');
        $value = input('value', '', 'int');
        if (empty($field)) {
            ajax_return_error('参数有误！');
        }
        $res = model('AuthGroup', 'logic')->change($val, $field, $value);
        if ($res) {
            ajax_return_ok([], '修改成功！');
        } else {
            ajax_return_error('修改失败！');
        }

    }

    public function changeall()
    {
        $val   = input('val', '', 'trim');
        $field = input('field', '', 'trim');
        $value = input('value', '', 'int');
        if (empty($val)) {
            ajax_return_error('参数有误！');
        }
        if (empty($field)) {
            ajax_return_error('参数有误！');
        }

        $ids = explode(',', $val);
        foreach ($ids as $v) {
            $res = model('AuthGroup', 'logic')->change($v, $field, $value);
        }

        ajax_return_ok([], '修改成功！');

    }


}
