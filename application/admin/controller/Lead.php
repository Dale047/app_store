<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/1
 * Time: 下午9:44
 */

namespace app\admin\controller;
use app\common\lib;
use think\Request;

class Lead extends Common
{
    public function index()
    {
        /*主页数据展示层*/
        $res = Model('Lead')->tree();
        $this->assign('res',$res);
        return $this->fetch();
    }

    public function del()
    {
        $id = lib\Other::getId();
        $res = Model('Lead')->delData($id);
        if(!$res){
            $this->error('删除错误');
        }
        return $this->success('删除成功');
    }

    public function edit()
    {
        $id = lib\Other::getId();
        if(request()->isPOST()){
            $title = Request::instance()->param('title');
            $res = Model('Lead')->save(['title' => $title],['id' => $id]);
            if(!$res){
                $this->error('参数错误');
            }
            return $this->success('修改成功');
        }else {
            $res = Model('Lead')->checkData($id);
            $this->assign('res', $res);
            //halt($res);
            return $this->fetch();
        }
    }

    public function add()
    {
        if(request()->isPOST()){
            $data = input('post.');
            //var_dump($data);
            $Plevel = Model('Lead')->getPlevel($data['pid']);
            if($Plevel){
                $data['level'] = $Plevel['0']+1;
                if($data['level'] == 3){
                    $this->error('只允许添加一级菜单和二级菜单');
                }
            }else{
                $data['level'] = 1;
            }
            $res = Model('Lead')->save($data);
            if(!$res){
                $this->error('参数错误');
            }
            return $this->success('添加成功');
        }else {
            $res = Model('Lead')->tree();
            $this->assign('nav', $res);
            return $this->fetch();
        }
    }
}