<?php

namespace app\admin\model;

use \think\Model;
use \think\Db;
use traits\model\SoftDelete;



class Grade extends Model
{
    use SoftDelete;
    // protected $table = 'tp_user_info';
    protected $autoWriteTimestamp = true;
    
}
