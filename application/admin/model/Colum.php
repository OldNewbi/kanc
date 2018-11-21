<?php
namespace app\admin\model;
use think\Model;
class Colum extends Model{
    //无限分类
    public function colTree(){
        $col=$this->order('sort desc')->select();
        //$data=$col->toArray();
        //dump($col[0]->toArray());
        return $this->sort($col);
    }
    //改造数组
    private function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach($data as $key=>$value){
            if($value['pid']==$pid){
                $value['level']=$level;
                $arr[]=$value;
                $this->sort($data,$value['id'],$level+2);
            }
        }
        return $arr;
    }
    //获取子分类id
    public function getChildId($id){
        $col=$this->select();
        return $this->_getChildId($col,$id);
    }
    public function _getChildId($col,$id){
        static $arr=array();
        foreach($col as $k=>$v){
            if($v['pid']==$id){
                $arr[]=$v['id'];
                $this->_getChildId($col,$v['id']);
            }
        }
        return $arr;
    }
    //删除
    public function delCol($id){
        if($this::destroy($id)){
            return true;
        }else{
            return false;
        }
    }
    //排序
    public function sortC($data){
        //改造数组批量更新
        $list=array();
        $listSon=array();
        foreach ($data as $k=>$v){
            $listSon['id']=$k;
            $listSon['sort']=$v;
            $list[]=$listSon;
        }
        return $this->saveAll($list);
    }
}