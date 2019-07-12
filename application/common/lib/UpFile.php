<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/2
 * Time: 下午7:16
 */

namespace app\common\lib;
use think\Request;
use think\Controller;
use app\admin\Controller\Common;

class UpFile extends Controller
{
    /**
     * @return array() | $info
     * FileTypeJudge() 判断文件属性
     * 返回布尔文件移动信息
     */
    public static function UpFile()
    {
        $request = new Common;
        $file = $request->requestData()->file('file');
        if(empty($file) || !isset($file)){
            echo "<script>alert('请选择文件');history.back()</script>";
            exit();
        }
        /*移动目标文件*/
        $info = $file->move('./APP/');
        return $info;
    }
}