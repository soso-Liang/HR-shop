<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * [p 数组]
 * @return [type] [description]
 */
function p($arr)
{
    echo "<pre>" . print_r($arr, true) . "</pre>";
}

/**
 * 由当前时间戳 + 5位随机数生成文件名
 * @return int 生成文件名
 */
function create_filename()
{
    return time() . mt_rand(10000, 99999);
}

/**
 * [check_mobile 校验 手机格式]
 * @param  [type] $phone [description]
 * @return [type]        [description]
 */
function check_mobile($phone)
{
    return preg_match("/1\d{10}$/", $phone);
}

/**
 * [check_email 校验邮箱格式]
 * @param  [type] $email [description]
 * @return [type]        [description]
 */
function check_email($email)
{
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    return preg_match($pattern, $email);
}

/**检测数字是否合法
 * @param $num 数字
 * @param int $length 小数位数
 * @return false|int
 */
function check_float($num, $length = 2)
{
    $rule = '/^[0-9]+(.[0-9]{1,' . $length . '})?$/';
    return preg_match($rule, $num);
}

/**
 * 用户密码加密方法，可以考虑盐值包含时间（例如注册时间），
 * @param string $pass 原始密码
 * @return string 多重加密后的32位小写MD5码
 */
function encrypt_pass($pass)
{
    if ('' == $pass) {
        return '';
    }
    $salt = config('system.pass_salt');
    return md5(sha1($pass) . $salt);
}

/**
 * 16位md5，
 * @param string $pass 原始密码
 * @return string 多重加密后的16位小写MD5码
 */
function md5_short($pass)
{
    if ('' == $pass) {
        return '';
    }
    $salt = config('system.pass_salt');
    return substr(md5(sha1($pass) . $salt), 8, 16);
}

/**
 * CURL快捷方法，post提交数据
 * @param string $url 提交目的地址
 * @param array $data post数据
 * @return url访问结果
 */
function curl_post($url, $data,$header =[])
{
    $ch     = curl_init();

    if (empty($header)){
        $header = array("Accept-Charset: utf-8", 'Expect:');
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    // 最好加上http_build_query 转换，防止有些服务器不兼容
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/**
 * CURL快捷方法，get提交数据
 * @param string $url 提交目的地址
 * @param array $data post数据
 * @return url访问结果
 */
function curl_get($url, $data,$header =[])
{
    $ch     = curl_init();
    if (empty($header)){
        $header = array("Accept-Charset: utf-8", 'Expect:');
    }
    $url    = $url . '?' . http_build_query($data);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


/**
 * 生成随机验证码，每一位都是单独从字典中随机获取的字符，字典是0-9纯数字。
 * @param number $length 验证码长度，默认6
 * @return string 指定长度的随机验证码。
 */
function create_random($length = 6)
{
    $chars = "0123456789";
    $str   = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * 抛出异常处理
 * @param string $msg 异常消息
 * @param integer $code 异常代码 默认为0
 * @param string $exception 异常类
 *
 * @throws Exception
 */
function my_exception($msg = null, $code = 0, $exception = '')
{
    if ($msg == null) {
        $msgDefault = config('error');
        $msg        = $msgDefault [$code];
    } else {
        $msg = $msg;
    }
    $e = $exception ?: '\think\Exception';
    throw new $e($msg, $code);
}

/**
 * 返回格式化信息
 * @param string/array $msg 信息内容
 * @param string $code 错误码
 * @param number $status 状态 0 错误 ，1 成功
 * @return array
 */
function msg_return($status = 0, $msg = null, $code = 0)
{
    return array('status' => $status, "code" => $code, "msg" => $msg);
}

/**
 * ajax 请求正确返回
 * @param string $msg
 * @param array $data
 * @return json
 */
function ajax_return_ok($data = array(), $msg = '')
{
    $result['status'] = 1;
    $result['data']   = $data;
    $result['msg']    = $msg;
    $result['code']   = 10000;
    // 返回JSON数据格式到客户端 包含状态信息
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($result));
}

/**
 * ajax 请求错误返回
 * @param string $msg
 * @param string $code
 * @return json
 */
function ajax_return_error($msg = null, $code = 10001)
{
    if ($msg == null) {
        $msgDefault    = config('error');
        $result['msg'] = $msgDefault [$code];
    } else {
        $result['msg'] = $msg;
    }
    $result['status'] = 0;
    $result['code']   = $code;
    // 返回JSON数据格式到客户端 包含状态信息
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($result));
}

/**
 * 返回json
 * @param array $data
 */
function json_return($data = array())
{
    // 返回JSON数据格式到客户端 包含状态信息
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($data));
}


/**
 * 多个数组的笛卡尔积
 *
 * @param unknown_type $data
 */
function combine_dika()
{
    $data   = func_get_args();
    $data   = current($data);
    $cnt    = count($data);
    $result = array();
    $arr1   = array_shift($data);
    foreach ($arr1 as $key => $item) {
        $result[] = array($item);
    }
    foreach ($data as $key => $item) {
        $result = combine_array($result, $item);
    }
    return $result;
}


/**
 * 两个数组的笛卡尔积
 * @param unknown_type $arr1
 * @param unknown_type $arr2
 */
function combine_array($arr1, $arr2)
{
    $result = array();
    foreach ($arr1 as $item1) {
        foreach ($arr2 as $item2) {
            $temp     = $item1;
            $temp[]   = $item2;
            $result[] = $temp;
        }
    }
    return $result;
}

/**
 * 检测用户是否登录
 * $type 类型 admin，user
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login($type = 'admin')
{
    $admin = session($type);
    if (empty($admin)) {
        return 0;
    } else {
        return session($type . '_sign') === data_auth_sign($admin) ? $admin['uid'] : 0;
    }
}

function data_auth_sign($data)
{
    //数据类型检测
    if (!is_array($data)) {
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/** 自定义模型实例化 能指定模块
 * @param $name Model名称
 * @param $layer 业务层名称
 * @param $common 模块名
 * @param bool $appendSuffix 是否添加类名后缀
 * @return object
 */
function my_model($name, $layer, $common, $appendSuffix = false)
{
    return \think\Loader::model($name, $layer, $appendSuffix, $common);
}

/** 自定义实例化验证器 能指定模块
 * @param $name Model名称
 * @param $layer 业务层名称
 * @param $common 模块名
 * @param bool $appendSuffix 是否添加类名后缀
 * @return object
 */
function my_validate($name, $common, $layer = 'validate', $appendSuffix = false)
{
    return \think\Loader::validate($name, $layer, $appendSuffix, $common);
}

/** 输入特殊字符过滤
 * @param $str
 * @return string
 */
function str_filter($str)
{
    if (empty ($str) || "" == $str) {
        return "";
    }
    $str = strip_tags($str);
    $str = htmlspecialchars($str);
    $str = nl2br($str);
    $str = str_replace("select", "", $str);
    $str = str_replace("join", "", $str);
    $str = str_replace("union", "", $str);
    $str = str_replace("where", "", $str);
    $str = str_replace("insert", "", $str);
    $str = str_replace("delete", "", $str);
    $str = str_replace("update", "", $str);
    $str = str_replace("like", "", $str);
    $str = str_replace("drop", "", $str);
    $str = str_replace("create", "", $str);
    $str = str_replace("modify", "", $str);
    $str = str_replace("rename", "", $str);
    $str = str_replace("alter", "", $str);
    $str = str_replace("cast", "", $str);
    $str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    return trim($str);
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key 加密密钥
 * @param int $expire 过期时间 单位 秒
 * @return string
 */
function think_encrypt($data, $key = '', $expire = 0)
{
    $key  = md5(empty($key) ? config('extra.pass_salt') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time() : 0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
    }

    $str = str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
    return strtoupper(md5($str)) . $str;
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key 加密密钥
 * @return string
 */
function think_decrypt($data, $key = '')
{
    $key  = md5(empty($key) ? config('extra.pass_salt') : $key);
    $data = substr($data, 32);
    $data = str_replace(array('-', '_'), array('+', '/'), $data);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data   = substr($data, 10);

    if ($expire > 0 && $expire < time()) {
        return '';
    }
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}