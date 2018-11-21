<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Conf as ConfModel;
class Conf extends Controller{
    public function index(){
        $confModel=new ConfModel();
        $data=$confModel->paginate(6);
        $page=$data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        return view();
    }
    //配置项目
    public function list(){
        if(\request()->isPost()){

        }else{
            $data=db('conf')->select();
            $this->assign('data',$data);
            return view();
        }
    }
    //添加
    public function add(){
        if(\request()->isPost()){
            $confModel=new ConfModel();
            //dump(input('post.'));
            $data=input('post.');
            //替换中文逗号
            $data['vals']=str_replace('，',',',$data['vals']);
            $res=$confModel->save($data);
            if($res){
                $this->success('添加配置成功！','index','',1);
            }else{
                $this->error('添加配置失败！');
            }
        }else{
            return view();
        }
    }
    //删除
    public function del($id){
        $confModel=new ConfModel();
        $res=$confModel->delC($id);
        if($res){
            $this->success('删除配置成功！','index','',1);
        }else{
            $this->error('删除配置失败！');
        }
    }
    //修改
    public function update($id){
       if(\request()->isPost()){
            //dump(input('post.'));
           $data=input('post.');
           $confModel=new ConfModel();
           $result=$confModel->save($data,['id'=>$id]);
           if($result){
               $this->success('修改配置成功！','index','',1);
           }else{
               $this->error('修改配置失败！');
           }
       }else{
           $confModel=new ConfModel();
           $data=$confModel->find($id);
           $this->assign('data',$data);
           return view();
       }
    }
}