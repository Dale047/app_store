<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/6
 * Time: 下午8:14
 */

namespace app\admin\controller;
use app\common\lib;
use think\Request;
use app\index\controller;

class Customer extends Common
{
    public function index()
    {
        $userInfo = $this->AllCust();
        $this->assign([
            'data' => $userInfo
        ]);
        return $this->fetch();
    }

    public function addAccount()
    {
        if(request()->isPost()){
            $data = input('post.');
            $user = $this->GetUser($data['username']);
            /*加积分数额*/
            $NeedInte = $data['ninte'];
            /*剩余积分*/
            $MyInte = $user['inte'];

            /*处理数据,返回加钱后的最终数据*/
            $inte = $this->countApp($NeedInte,$MyInte);

            $updateRes = Model('Customer')->save(['inte'=>$inte],['username'=>$data['username']]);

            $data = [
                'username' => $data['username'],
                'appname'  => '充值积分'.$data['ninte'],
                'ninte'    => $data['ninte'],
                'minte'    => $inte,
                'status'   => '1'
            ];

            $addRes = Model('Download')->save($data);
            if(!($updateRes && $addRes)){
                $this->error('参数错误');
            }
            return $this->success('充值成功');
        }else {
            $this->index();
            return $this->fetch();
        }
    }

    public function Restatus()
    {
        $id = lib\Other::getId();
        $status = Request::instance()->param('status');
        $res = Model('Customer')->save(['status'=>$status],['id'=>$id]);
        if(!$res){
            $this->error('参数错误');
        }
        $this->redirect('admin/customer/index');
    }

    public function AllCust()
    {
        $userInfo = Model('Customer')->AllCust();
        return $userInfo;
    }

    public function GetUser($username)
    {
        $user = Model('Customer')->get(['username'=>$username]);
        return $user;
    }

    public function countApp($NeedInte,$MyInte)
    {
        $inte = $MyInte+$NeedInte;
        return $inte;
    }

}