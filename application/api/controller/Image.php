<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;

class Image extends Controller
{
    /**
     * @return array
     * @param int status
     * @param str message
     */
    public function upload()
    {
        $file = Request::instance()->file('file');  //上传文件的请求方式
        $info = $file->move('./icon/');  //文件的上传位置，public/upload/文件夹下
        if($info && $info->getPathname())
        {
            /*
             * show()函数写在了公共文件夹里
             * status 表示状态 1 成功 0 失败
             * message 表示提示语
             * 提交的数据
             */
            return show(1,'success','/tsapp/public/'.$info->getPathname());
            /*
             * 这个地方错误我修改了一晚上！
             * 原来是因为路径这出错了！
             */
        }else{
            return show(0,'upload error');
        }
    }
}
