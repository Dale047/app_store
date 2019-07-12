<?php
/**
 * Created by PhpStorm.
 * User: dale047
 * Date: 2019/4/5
 * Time: 下午2:56
 */
namespace app\common\validate;
use think\Validate;

class Register extends Validate
{
    protected $rule = [
        ['relname','chs|max:10','用户名只能是汉字|用户名最多10个汉字'],
        ['username','chsAlphaNum','用户名有非法字符'],
        ['tel','number|max:15','手机号码只能含有数字|手机号码最多15位'],
        ['qq','number|max:15','手机号码只能含有数字|手机号码最多15位']
    ];

    protected $scene = [
        'checkReg' => ['relname','username','tel','qq'],
    ];
}