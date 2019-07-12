<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/3/30
 * Time: 下午8:39
 */
namespace app\common\lib;
use think\Controller;

class SetPassword extends Controller
{
    public static function SetMDPassword($password){
        return md5(config('AdminLogin.SetPassword_start').$password.config('AdminLogin.SetPassword_end'));
    }

    public static function CheckSamPassword($pwd1,$pwd2){
        if($pwd1==$pwd2){
            return false;
        }
        return true;
    }

    public function CheckSamCustomer($username){
        $res = Model('Customer')->get(['username'=>$username]);
        if($res){
            $this->error('抱歉，该用户已存在');
        }
    }

    public function LoginUser($username,$password){
        $res = Model('Customer')->get(['username'=>$username,'password'=>SetPassword::SetMDPassword($password)]);
        if(!$res){
            $this->error('用户名或密码错误');
        }
        return $res;
    }
}