<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/6
 * Time: 下午6:35
 */

namespace app\index\controller;


class Account extends Common
{
    public function index()
    {
        $userInfo = $this->isLogin();
        $userDownList = $this->getListAccount($userInfo['username']);
        $this->assign([
            'downlist' => $userDownList
        ]);
        return $this->fetch();
    }

    public function getListAccount($username)
    {
        $list = Model('Download')->getListDownload($username);
        return $list;
    }

    public function conf()
    {
        $data = Model('Chm')->getAllMsg();
        $this->assign([
            'data' => $data
        ]);
        return $this->fetch();
    }
}