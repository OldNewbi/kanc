<?php
namespace app\admin\model;
use think\Model;
class AuthGroup extends Model{
    //插入
    public function add_authGroup($arr){
        return $this->insert($arr);
    }
    //删除
    public function del_authGroup($id){
        return $this::destroy($id);
    }
}