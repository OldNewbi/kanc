<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Colum as ColumModel;
use think\Request;

class Colum extends Controller{
    public function index(){
        $colum=new ColumModel;
        $count=$colum->count();
        $this->assign('count',$count);
        $data=$colum->colTree();
        $this->assign('data',$data);
        return view();
    }
    //添加
    public function add(){
        //dump(input('post.'));
        $data=input('post.');
        $colum=new ColumModel;
        $validate=\think\Loader::validate('Colum');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $res=$colum->save($data);
        if($res){
            $this->success('添加成功','index','',1);
        }else{
            $this->error('添加失败');
        }
    }
    //前置操作
    protected $beforeActionList=['delSon'=>['only'=>'del']];

    public function delSon(){
        $id=input('id');
        $colum=new ColumModel();
        $idx=$colum->getChildId($id);
        if($idx){
            db('colum')->delete($idx);
        }

    }
    //删除（如果删除的是上级栏目，则应该把子栏目一并删除）
    public function del($id){
        $colum=new ColumModel();
        $res=$colum->delCol($id);
        if($res){
            $this->success('删除成功','index','',1);
        }else{
            $this->error('删除失败');
        }
    }
    //更新
    public function update($id){
        $colum=new ColumModel();
        if(\request()->isPost()){
            $data=input('post.');
            $result=$colum->save($data,['id'=>$id]);
            if($result){
                $this->success('修改成功','index','',1);
            }else{
                $this->error('修改失败');
            }
        }else{

            $fdata=$colum->find($id);
            $this->assign('fdata',$fdata);
            //分类显示
            $data=$colum->colTree();
            $this->assign('data',$data);
            return view();
        }
    }
    //排序
    public function sort(){
        $data=input('post.');
        $colum=new ColumModel();
        $res=$colum->sortC($data);
        if($res){
            $this->success('排序修改成功！','index','',1);
        }else{
            $this->error('排序修改失败！');
        }
    }
}