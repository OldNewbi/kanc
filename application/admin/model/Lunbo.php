<?php
namespace app\admin\model;
use think\Model;
class Lunbo extends Model{
    //添加
    public function addL($arr){
        if($this->save($arr)){
            return true;
        }else{
            return false;
        }
    }
    //删除
    public function delL($id){
        $data=$this->find($id);
        $file="./static/uploads/{$data['img']}";
        if(file_exists($file) && $data['img']) unlink($file);
        return $this->destroy($id);
    }
}