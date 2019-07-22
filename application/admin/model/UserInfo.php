<?php

namespace app\admin\model;

use \think\Model;
use \think\Db;
use traits\model\SoftDelete;



class UserInfo extends Model
{
    use SoftDelete;
    protected $table = 'tp_user_info';
    protected $autoWriteTimestamp = true;
    public function index()
    {
        $user = UserInfo::where()->paginate(10);
    }
    public function levels()
    {
        return $this->hasMany('Grade','id','grade_id')->field('id,name,level');
    }
}
