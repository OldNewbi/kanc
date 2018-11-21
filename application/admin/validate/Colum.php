<?php
namespace app\admin\validate;
use think\Validate;
class Colum extends Validate{
    //规则
    protected $rule=[
        'name'=>'require|unique:Colum',
    ];
    //验证消息
    protected $message=[
        'name:require'=>'栏目名称不能为空',
        'name:unique'=>'栏目名称已被占用'
    ];
    //验证场所
    protected $scene=[
        'add'=>['name'],
    ];
}