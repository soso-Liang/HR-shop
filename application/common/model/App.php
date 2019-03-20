<?php

namespace app\common\model;

use \think\Model;
use \think\Db;

/**
 * 应用相关操作
 */
class App extends Model
{
    /** 通过appID获取信息
     * @param $appId
     */
    public function getAppByAppId($appId)
    {
        $where = ['appId' => $appId];
        $app   = Db::name('app')->where($where)->find();
        return $app;
    }

    /** 更新
     * @param array $id
     * @param array $data
     * @return $this|void
     */
    public function modify($id, $data)
    {
        return Db::name('app')->where(['id' => $id])->update($data);
    }


}
