<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/3/30
 * Time: 下午10:09
 */

namespace app\admin\controller;

class Index extends Common
{
    public function index()
    {
        $userInfo = $this->getLoginUser();
        $this->assign('userInfo',$userInfo);
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }
}