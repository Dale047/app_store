<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function traTime($time){
    return date("Y年m月d日 H时m分",$time);
}

/**
 * @param $status 分类状态
 * @return string
 */
function LevelStatus($status){
    if($status==1){
        $status = "<span class='label label-success'>正常</span>";
    }elseif($status==0){
        $status = "<span class='label label-danger'>停用</span>";
    }else{
        $status = $str = "<span class='label label-danger'>参数错误</span>";
    }
    return $status;
}

function AppName($AppName,$level){
    //$str = "|"."-"*$level;
    if($level == 0){
        return "||=".$AppName;
    }else {
        $str = "";
        for ($i = 0; $i < $level; $i++) {
            $str .= "==";
        }
        return "||=" . $str . $AppName;
    }
}

function getPNav($appId){
    $PNavName = Model('Lead')->get(['id'=>$appId]);
    return $PNavName['title'];
}
