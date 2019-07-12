<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/1
 * Time: 下午10:39
 */

namespace app\common\model;
use think\Model;

class Common extends Model
{
    public function delData($id)
    {
        $data = [
            'id' => $id
        ];
        return $this->where($data)->delete();
    }

    public function checkData($id)
    {
        $data = [
            'id' => $id
        ];
        return $this->where($data)->select();
    }

    public function getAllMsg()
    {
        return $this->select();
    }

    public function countData()
    {
        return $this->count();
    }

    public function checkSamName($name)
    {
        $data = [
            'title' => $name
        ];

        return $this->where($data)->select();
    }
}