<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/3/31
 * Time: 下午1:05
 */

namespace app\common\model;
use think\Model;

class AdminLogin extends Model
{
    public function countLogin()
    {
        return $this->count();
    }

    public function getLastLogin($username)
    {
        $data = [
            'username' => $username,
            'status' => 1
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}