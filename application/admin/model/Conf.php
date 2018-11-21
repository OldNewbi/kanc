<?php
namespace app\admin\model;
use think\Model;
class Conf extends Model{
    //删除
    public function delC($id){
        return $this::destroy($id);
    }
}