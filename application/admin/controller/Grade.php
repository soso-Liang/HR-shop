<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use \think\Db;
use \app\admin\model\Grade as GradeModel;
// use \app\admin\validate\UserInfo as UserValidate;


/**
 * 
 */
class Grade extends Base
{

    public function index()
    {
        $page = input('page');
        $page_size = 10;
        $current_page = $page;

        $levels = GradeModel::paginate(2, false, [
            'page'  =>  $current_page,
        ]);
        return ajax_return_ok($levels);
    }
    // 添加等级
    public function add()
    {
        $keyword = input('');
        $level = new GradeModel();
        $reulut = $level->where('name', $keyword['level_name'])->select();
        if ($reulut) {
            return ajax_return_error('等级已存在');
        }
        else{
            $level -> data([
                'name'   =>    $keyword['level_name'],
            ])->save();
        }
        return ajax_return_ok([], '添加成功');
    }
    // 用户名是否已存在
    public function isExist()
    {
        $keyword = input('keyword');
        $user = new User();
        $reulut = $user->where('user_name', $keyword)->select();
        // dump($reulut);
        if ($reulut) {
            return ajax_return_error('用户名已存在');
        }
        return ajax_return_ok([], '用户名可用');
    }

    // 新建
    public function create()
    {
        $data = input('');
        $user = new User;
        if (!empty($data['user_name'])) {
            $user->user_name = $data['user_name'];
        }
        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }
        if (!empty($data['email'])) {
            $user->email = $data['email'];
        }
        if (!empty($data['nick_name'])) {
            $user->nick_name = $data['nick_name'];
        }
        if (!empty($data['real_name'])) {
            $user->real_name = $data['real_name'];
        }
        if (!empty($data['thumb'])) {
            $user->thumb = $data['thumb'];
        }
        if ($data['tel_phone']) {
            $user->tel_phone = $data['tel_phone'];
        }
        if ($data['birthday']) {
            $user->birthday = $data['birthday'];
        }
        $result = $this->validate($data, 'UserInfo');
        if (true !== $result) {
            return ajax_return_error(validate('UserInfo')->getError());
        }
        $user->save();

        return ajax_return_ok('[]', '保存成功！');
    }

    // 编辑
    public function edit()
    {
        $data = input();
        $id = $data['user_id'];
        $user = new User();
        $result = $user->where('user_id', $id)->find();
        if (!$result) {
            return ajax_return_error('用户不存在或已删除！');
        }
        $validate = $this->validate($data, 'UserInfo');
        if (true !== $validate) {
            return ajax_return_error(validate('UserInfo')->getError());
        }
        $user->allowField(true)->save($data, ['user_id' => $id]);
        return ajax_return_ok('[]', '修改成功！');
    }

    public function del()
    {
        $ids = input('');
        $id = $ids['id'];
        if ($id == 0 || !is_int($id)) {
            return ajax_return_error('参数错误！');
        }
        $user = User::get($id);
        if (!$user) {
            return ajax_return_error('该用户不存在或已删除！');
        }
        $user->delete();
        return ajax_return_ok('[]', '删除成功！');
    }

    public function getInfo()
    {
        $ids = input('');
        $id = $ids['id'];
        if ($id == 0 || !is_int(intval($id))) {
            return ajax_return_error('参数错误！');
        }
        $user = User::get($id);
        if (!$user) {
            return ajax_return_error('该用户不存在或已删除！');
        }
        $user->levels;
        return ajax_return_ok($user, '获取成功！');
    }
}
