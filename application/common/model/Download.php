<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/6
 * Time: 下午2:54
 */

namespace app\common\model;


class Download extends Common
{
    protected $autoWriteTimestamp = true;

    protected $updateTime = false;

    public function getListDownload($username)
    {
        $data = [
            'username' => $username
        ];

        $order = [
            'create_time' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate(10);
    }
}