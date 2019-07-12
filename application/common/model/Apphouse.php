<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/2
 * Time: 下午8:11
 */

namespace app\common\model;

class Apphouse extends Common
{
    protected $autoWriteTimestamp = true;

    public function SaveApp($data)
    {
        return $this->allowField(true)->save($data);
    }

    public function getApp($title)
    {
        $data = [
            'status' => 1
        ];

        return $this->where('title','like','%'.$title.'%')
                    ->where($data)
                    ->paginate(20);
    }

    public function setApp($appId)
    {
        $data = [
            'status' => 1,
            'appId'  => $appId
        ];

        return $this->where($data)
                    ->paginate(20);
    }
}