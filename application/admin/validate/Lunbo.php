<?php
namespace app\admin\validate;
use think\Validate;
class Lunbo extends Validate{
    //验证规则
    protected $rule=['img'=>'require'];
    //验证消息
    protected $message=['img:require'=>'上传的图片不能为空'];
    //验证场所
    protected $scene=['add'=>['img']];
}