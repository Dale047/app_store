<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/1
 * Time: 下午9:16
 */

namespace app\admin\controller;
use app\common\lib;
use think\Request;

class App extends Common
{
    public function index()
    {
        $countData = Model('Apphouse')->countData();
        $data = Model('Apphouse')->getAllMsg();
        $this->assign([
            'data' => $data,
            'countData' => $countData
        ]);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPOST()){
           $data = $this->requestData()->param();
           $isLevel = $this->checkLevel($data['appId']);
           if($isLevel){
               $this->error('禁止选择一级菜单');
           }
           $fileData = lib\UpFile::UpFile();
           $data['FileSrc'] = $fileData->getPathname();
           //$data['FileType'] = $fileData->getInfo()['type'];
           $data['title'] = $fileData->getInfo()['name'];
           $res = Model('Apphouse')->checkSamName($data['title']);
           if($res){
               $this->error('该软件已存在');
           }
           /*$file->getInfo()['name']; 获取文件上传名*/
           $title = $fileData->getInfo()['name'];
           $file_num = strrpos($title, '.');
           $data['FileType'] = substr($title, $file_num + 1);

           $data['FileSize'] = round(($fileData->getSize())/(1024*1024),2);
           $res = Model('Apphouse')->SaveApp($data);
           if(!$res){
               $this->error('参数错误');
           }
           return $this->success('保存成功');
        }else {
            $res = Model('Lead')->tree();
            $this->assign('nav', $res);
            return $this->fetch();
        }
    }

    public function reStatus()
    {
        $res = $this->changeStatus();
        if(!$res){
            $this->error('参数错误');
        }
        return $this->redirect('admin/app/index');
    }

    public function delData()
    {
        $id = lib\Other::getId();
        $res = Model('Apphouse')->delData($id);
        if(!$res){
            $this->error('参数错误');
        }
        return $this->success('删除成功');
    }

    public function edit()
    {
        $id = lib\Other::getId();
        $data = Model('Apphouse')->checkData($id);
        $res = Model('Lead')->tree();
        $this->assign('nav', $res);
        $this->assign([
            'data' => $data,
            'nav'  => $res
            ]);
        return $this->fetch();
    }
}