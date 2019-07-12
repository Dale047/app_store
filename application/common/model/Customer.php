<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/5
 * Time: 下午3:40
 */

namespace app\common\model;


class Customer extends Common
{
    protected $autoWriteTimestamp = true;

    protected $updateTime = false;

    public function AddCustomer($data)
    {
        if(!is_array($data)){
            echo "<script type='text/javascript'>alert('非法传参！');history.back();</script>";
            exit();
        }
        $this->allowField(true)->save($data);
        return $this->id;
    }

    public function AllCust()
    {
        return $this->paginate(10);
    }
}