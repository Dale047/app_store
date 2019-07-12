<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/1
 * Time: 下午10:20
 */

namespace app\common\lib;
use think\Controller;
use think\Request;

class Other extends Controller
{
    public static function getId()
    {
        $id = Request::instance()->param('id');
        return $id;
    }
}