<?php
namespace app\admin\model;
use think\Model;
class Manger extends Model{
    //添加
    public function addM($arr){
        $arr['password']=md5($arr['password']);
        if($this->save($arr)){
            return true;
        }else{
            return false;
        }
    }
    //删除
    public function delM($arr){
        return $this::destroy($arr);
    }
    //更新
    public function editM($arr){
        if($arr['password']){
            $arr['password']=md5($arr['password']);
        }else{
            $data=$this->find($arr['id']);
            $arr['password']=$data['password'];
        }
        $res=$this->save(['username'=>$arr['username'],'password'=>$arr['password'],'status'=>$arr['status']],['id'=>$arr['id']]);
        return $res;
    }
    //更换状态
    public function statusM($arr){
        switch ($arr['status']){
            case 0:
                $res=$this::update(['id'=>$arr['id'],'status'=>1]);
                break;
            case 1:
                $res=$this::update(['id'=>$arr['id'],'status'=>0]);
                break;
            default:
                $res=0;
        }
        return $res;
    }
}