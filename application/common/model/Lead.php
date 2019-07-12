<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/3/28
 * Time: 下午9:24
 */

namespace app\common\model;

class Lead extends Common
{
    protected $autoWriteTimestamp = true;

    /**
     * @param array $data 获取一级菜单参数
     * @return array 获取一级菜单
     */
    public function getFirstNav()
    {
        $data = [
            'pid' => '0',
            'level' => '1'
        ];

        return $this->where($data)->select();
    }

    /**
     * @param $id pid为父类的主键id
     * @return array 子类二级菜单数据
     */
    public function getSecNav($id)
    {
        $data = [
            'pid' => $id
        ];

        return $this->where($data)->select();
    }

    /**
     * @param $pid 子类pid等于父类主键id
     * @return String 筛选字段 level
     */
    public function getPlevel($pid)
    {
        $data = [
            'id' => $pid
        ];
        return $this->where($data)->column('level');
    }

    public function tree()
    {
        $data = [
            'status' => 1
        ];
        $data = $this->where($data)->select();
        return $this->sort($data);
    }

    public function sort($data,$pid=0)
    {
        static $arr = array();
        foreach ($data as $k=>$v){
            if($v['pid']==$pid){
                $arr[] = $v;
                $this->sort($data,$v['id']);
            }
        }
        return $arr;
    }
}