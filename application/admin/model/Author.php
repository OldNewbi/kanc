<?php
namespace app\admin\model;
use think\Model;
class Author extends Model{
    //添加
    public function addA($arr){
        if($this->save($arr)){
            return true;
        }else{
            return false;
        }
    }
    //删除
    public function delA($id){
        $data=$this->find($id);
        $file="./static/uploads/{$data['photo']}";
        if(file_exists($file) && $data['photo']) unlink($file);
        return $this->destroy($id);
    }
}