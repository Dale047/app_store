<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/5
 * Time: 下午8:46
 */

namespace app\index\controller;
use Org\Net\Http;
use think\Request;
use think\Loader;

class Stock extends Common
{
    public function index()
    {
        if(!request()->isGET()){
            $this->error('请求方式错误');
        }
        $title = Request::instance()->param('title');
        //echo $title;
        $data = Model('Apphouse')->getApp($title);
        //print_r($data);
        $this->assign([
            'data' => $data
        ]);
        return $this->fetch();
    }

    public function seAppId()
    {
        $appId = Request::instance()->param('appId');
        //echo $appId;
        $data = Model('Apphouse')->setApp($appId);
        $this->assign([
            'data' => $data
        ]);
        return $this->fetch('index');
    }

    public function check()
    {
        $appId = Request::instance()->param('id');
        $data = $this->getAppInfo($appId);
        $this->assign([
            'data' => $data
        ]);
        return $this->fetch();
    }

    public function downloadFile()
    {
        $isLogin = $this->GetThisUser();
        if(!$isLogin){
            $this->error('请先登录');
        }
        $id = Request::instance()->param('id');
        if(empty($id) || $isLogin['status'] != 1){
            $this->error('非法操作');
        }
        $data = $this->getAppInfo($id);
        $url = config('download.http_ip_add').$data['FileSrc'];
        if(!file_exists($url)){
            header('HTTP/1.1 404 Not Found');
        }
        /*************************数据更新预处理**********************/
        $NeedInte = $data['inte']; //APP需要积分
        $MyInte   = $isLogin['inte']; //当前用户积分

        /*
        $inte = $MyInte-$NeedInte;
        echo  $MyInte.'-'.$NeedInte.'='.$inte;
        die;
        */

        /*更新当前用户余额*/
        $res = $this->updateApp($NeedInte,$MyInte);
        if(!$res){
            $this->downloadApp($data,$isLogin,$status=0);
        }
        /*添加下载记录*/
        $this->downloadApp($data,$isLogin,$status=1);
        echo "<meta http-equiv=\"refresh\" content=\"1;url='$url'\"> ";
    }

    public function getAppInfo($appId)
    {
        $data = Model('Apphouse')->get(['id'=>$appId]);
        return $data;
    }

    /**
     * @param $data array APP软件所有数据信息
     * @param $isLogin array 当前用户所有数据信息
     * @return bool 更新状态
     */
    public function updateApp($NeedInte,$MyInte)
    {
        $isLogin = $this->GetThisUser();
        if($NeedInte>$MyInte){
            $this->error('抱歉，您当前积分不够',url('index/account/conf'));
        }
        /*积分余额*/
        $inte = $this->countApp($NeedInte,$MyInte);
        /*数据库操作*/
        $res = Model('Customer')->save(['inte'=>$inte],['id'=>$isLogin['id']]);
        if(!$res){
            return false;
        }
        return $res;
    }

    /**
     * @param $MyInte
     * @param $NeedInte
     * @return int 当前用户剩余积分
     */
    public function countApp($NeedInte,$MyInte)
    {
        $inte = $MyInte-$NeedInte;
        return $inte;
        //return $MyInte.'-'.$NeedInte.'='.$inte;
    }

    public function downloadApp($data,$isLogin,$status=1)
    {
        /*软件需要积分*/
        $NeedInte = $data['inte'];
        /*当前账户积分*/
        $MyInte = $isLogin['inte'];
        /*积分余额*/
        $inte = $this->countApp($NeedInte,$MyInte);
        $udat = [
            'username' => $isLogin['username'],
            'appname'  => $data['title'],
            'ninte'    => $data['inte'],
            'minte'    => $inte,
            'status'   => $status
        ];
        $res = Model('Download')->save($udat);
        if(!$res){
            $this->error('参数错误');
        }
        return true;
    }
}