<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/3/30
 * Time: 下午8:14
 */

namespace app\admin\controller;
use app\common\lib;

class Login extends Common
{
    public function _initialize()
    {
        /*避免重复提交*/
        /*********************************/
        /*网站名称*/
        $SiteName = Model('Config')->getSiteName();
        $this->assign('SiteName',$SiteName);
        /*站点版权名称*/
        $SiteCopy = Model('Config')->getSiteCopy();
        $this->assign('SiteCopy',$SiteCopy);
        /*站点归属学院名称*/
        $SiteCollege = Model('Config')->getSiteCollege();
        $this->assign('SiteCollege',$SiteCollege);
        /*站点首页提示*/
        $BannerTip = Model('Config')->getBannerTip();
        $this->assign('BannerTip',$BannerTip);
    }

    public function index()
    {
        if(request()->isPost()){
            $data = input('post.');
            if (!captcha_check($data['code']) || empty($data['code'])) {
                echo "<script type='text/javascript'>alert('验证码错误！');history.back();</script>";
                exit();
            }
            $res = Model('Admin')->get(
                [
                    'username'=>$data['username'],
                    'password'=>lib\SetPassword::SetMDPassword($data['password'])
                ]
            );
            if(!$res){
                $this->error('用户名或密码错误');
            }
            session(config('AdminLogin.Login_Start'),$res,config('AdminLogin.Login_End'));
            $udata = [
                'username' => $res['username'],
                'last_login_ip' => \request()->ip(),
                'last_login_time' => time(),
                'status' => 1
            ];
            $status = Model('AdminLogin')->save($udata);
            if(!$status){
                $this->error('状态更新数据失败');
            }
            return $this->success('验证成功，请等待',url('admin/index/index'));
        }
        return $this->fetch();
    }
}