<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/3/28
 * Time: 下午7:51
 */
namespace app\common\model;
use think\Model;
class Config extends Model
{
    public function getSiteName()
    {
        $data = [
            'name' => 'title'
        ];
        return $this->where($data)->select();
    }

    public function getSiteCopy()
    {
        $data = [
            'name' => 'copy'
        ];
        return $this->where($data)->select();
    }

    public function getSiteCollege()
    {
        $data = [
            'name' => 'college'
        ];
        return $this->where($data)->select();
    }

    public function getBannerTip()
    {
        $data = [
            'name' => 'bannertip'
        ];
        return $this->where($data)->select();
    }
}