<?php

namespace app\index\controller;
use \think\Db;
/**
 * 接口基类
 * @author xiegaolei
 *
 */
class Test
{
    //生成签名
    public function index()
    {
        $param     = input("param.");
		$appid 	= $param['appid'];
		if(empty($appid)){
			ajax_return_error('请填写appid');
		}
		unset($param['appid']);
		unset($param['token']);
        $signature = $this->getSgin($appid,$param);
        ajax_return_ok(['sign' => $signature]);
    }

    //请求数据
    public function getdata()
    {
        $data  = array();
        $param = input("param.");
        $url   = $param['url'];
        $api   = $param['api'];
        if (empty($url) || empty($api)) {
            ajax_return_error('请填写接口地址');
        } else {
            $url = $url . $api;
        }
        
		$head = ["x-access-appid:".$param['appid'],"x-access-token:".$param['token']];
		$data['signature']   = $param['signature'];
        if (isset($param['data'])) {
            foreach ($param['data']['key'] as $k => $v) {
                if ($v) {
                    $data[$v] = $param['data']['value'][$k];
                }
            }
        }

        switch ($param['method']) {
            case 'POST' :
                $result = curl_post($url, $data,$head);
                break;
            case 'GET' :
                $result = curl_get($url, $data,$head);
                break;
            default:
                $result = '';
                break;
        }

        echo $result;

    }

    //生成签名
    protected function getSgin($appid,$param)
    {
		$app = Db::name('app')->where(['appId' => $appid])->find();
		if(empty($app)){
			ajax_return_error('appid无效');
		}
		
		$data  = array();
		if (isset($param['data'])) {
            foreach ($param['data']['key'] as $k => $v) {
                if ($v) {
                    $data[$v] = $param['data']['value'][$k];
                }
            }
        }
		 
		ksort($data);
        $str        = http_build_query($data);
        $signature = md5(sha1($str) . $app['appSecret']);
        return $signature;
    }


}
