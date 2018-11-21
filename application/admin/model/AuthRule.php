<?php
namespace app\admin\model;
use think\Model;
class AuthRule extends Model{
    //无限分类
    public function authRuleTree(){
        $data=$this->select();
        return $this->sort($data);
    }
    //改造数组
    private function sort($data,$pid=0){
        static $arr=[];
        foreach ($data as $k=>$v){
            if($v['pid']==$pid){
                $v['dataid']=$this->getParentId($v['id']);
                $arr[]=$v;
                $this->sort($data,$v['id']);
            }
        }
        return $arr;
    }
    //获取父分类ID、
    public function getParentId($did){
        $data=$this->select();
        return $this->_getParentId($data,$did,true);
    }
    public function _getParentId($data,$did,$clear=false){
        static $arr=array();
        if($clear) $arr=array();
        foreach ($data as $key=>$value){
            if($value['id']==$did){
                $arr[]=$value['id'];
                $this->_getParentId($data,$value['pid']);
            }
        }
        asort($arr);
        return $str=implode('-',$arr);
    }
    //删除
    public function delA($id){
        return $this::destroy($id);
    }
    //获取儿砸id
    public function getChild($id){
        $data=$this->select();
        return $this->_getChild($data,$id);
    }
    public function _getChild($data,$id){
        $arr=array();
        foreach ($data as $k=>$v){
            if($v['pid']==$id){
                $arr[]=$v['id'];
                $this->_getChild($data,$v['id']);
            }
        }
        return $arr;
    }
}