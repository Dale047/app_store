<?php
namespace app\index\controller;
use app\common\lib;
use think\Request;

class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function register()
    {
        $lib = $this->SetPwd();

        if(request()->isPOST()){
            $data = input('post.');
            $lib->CheckSamCustomer($data['username']);
            if (!captcha_check($data['code'])) {
                echo "<script type='text/javascript'>alert('验证码错误！');history.back();</script>";
                exit();
            }
            $res = lib\SetPassword::CheckSamPassword($data['password'],$data['passwords']);
            if($res){
                echo "<script type='text/javascript'>alert('两次密码不一致！');history.back();</script>";
            }
            $validate = validate('Register');
            if(!$validate->scene('checkReg')->check($data)){
                $this->error($validate->getError());
            }
            $data['password'] = lib\SetPassword::SetMDPassword($data['password']);
            $res = Model('Customer')->AddCustomer($data);
            if(!$res){
                $this->error('传参不合法');
            }
            return $this->success('欢迎加入，您是第'.$res.'名会员，100积分已到账',url('index/index/index'));
        }else {
            return $this->fetch();
        }
    }

    public function login()
    {
        $lib = $this->SetPwd();
        $data = input('post.');
        $LoginUser = $lib->LoginUser($data['username'],$data['password']);
        session(config('CustomerLogin.session_user'),$LoginUser,config('CustomerLogin.session_user_scope'));
        $this->success('欢迎回来,'.$LoginUser['relname']);
    }

    public function logout()
    {
        session(null,config('CustomerLogin.session_user_scope'));
        $this->redirect('index/index/index');
    }

    public function search()
    {
        $title = Request::instance()->param('search');
        $res = Model('Apphouse')->getApp($title);
        return json_encode($res);
    }
}
