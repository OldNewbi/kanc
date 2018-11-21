<?php
namespace app\admin\validate;
use think\Validate;
class Manger extends Validate{
    //验证规则
    protected $rule=[
        'username'=>'require|unique:Manger|max:16',
        'password'=>'require'
    ];
    //验证消息
    protected $message=[
        'username:require'=>'用户名不能为空',
        'username:unique'=>'该用户名已被使用',
        'username:max'=>'用户名长度不能超过12个字位',
        'password:require'=>'密码不能为空'
    ];
    //验证场所
    protected $scene=[
        'add'=>['username','password'],
        'edit'=>['username']
    ];
}