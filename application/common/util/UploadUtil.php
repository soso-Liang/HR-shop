<?php

namespace app\common\util;

use app\common\CommonConstant;
use think\File;

/**
 * 上传
 * @author hardphp@163.com
 *
 */
class UploadUtil
{

    /**
     * 上传图片
     */
    public static function upimage($name = '', $path = '')
    {

        if (empty($path)) {
            // 框架应用根目录/uploads/ 目录下
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'images';
        }
        $files = request()->file($name);
        $info  = $files->validate(['size' => 1024 * 1024 * 5, 'ext' => ['gif', 'jpg', 'jpeg', 'png']])->move($path);
        if ($info) {
            // 成功上传后 获取上传信息
            $url = '/uploads/images/' . $info->getSaveName();
            $url = str_replace('\\', '/', $url);
            return $url;

        } else {
            // 上传失败获取错误信息
            my_exception($files->getError(), CommonConstant::e_system_upload_file);
        }
    }


    /**
     * 上传视频
     */
    public static function upvideo($name = '', $path = '')
    {

        if (empty($path)) {
            // 框架应用根目录/uploads/ 目录下
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'video';
        }
        $files = request()->file($name);
        $info  = $files->validate(['size' => 1024 * 1024 * 5, 'ext' => ['mp4']])->move($path);
        if ($info) {
            // 成功上传后 获取上传信息
            $url = '/uploads/video/' . $info->getSaveName();
            $url = str_replace('\\', '/', $url);
            return $url;
        } else {
            // 上传失败获取错误信息
            my_exception($files->getError(), CommonConstant::e_system_upload_file);
        }
    }

    /**
     * 上传文件
     */
    public static function upfile($name = '', $path = '')
    {

        if (empty($path)) {
            // 框架应用根目录/uploads/ 目录下
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'file';
        }
        $files = request()->file($name);
        $info  = $files->validate(['size' => 1024 * 1024 * 5, 'ext' => ['xls', 'xlsx']])->move($path);
        if ($info) {
            // 成功上传后 获取上传信息
            $url = '/uploads/file/' . $info->getSaveName();
            $url = str_replace('\\', '/', $url);
            return $url;
        } else {
            // 上传失败获取错误信息
            my_exception($files->getError(), CommonConstant::e_system_upload_file);
        }
    }


}
