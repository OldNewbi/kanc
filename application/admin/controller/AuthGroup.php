<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthGroup as AuthGroupModel;
class AuthGroup extends Controller{
    public function index(){
        $data=db('auth_group')->select();
        $this->assign('data',$data);
        return view();
    }

    //返回模型
    public function getAuthGroupModel(){
        return new AuthGroupModel();
    }
    //添加
    public function add(){
        if(request()->isPost()){
            //dump(input('post.'));
            $data=input('post.');
            if($data['rules']) $data['rules']=implode(',',$data['rules']);
            $res=$this->getAuthGroupModel()->add_authGroup($data);
            if($res){
                $this->success('添加权限成功！','index','',1);
            }else{
                $this->error('添加权限失败！');
            }
        }else{
            $data=db('manger')->select();
            $this->assign('data',$data);
            //规则显示
            $auth=new AuthRuleModel();
            $tree=$auth->authRuleTree();
            $this->assign('tree',$tree);
            return view();
        }
    }
    //删除
    public function del($id){
        //dump($id);
        $res=$this->getAuthGroupModel()->del_authGroup($id);
        if($res){
            $this->success('删除权限成功！','index','',1);
        }else{
            $this->error('删除权限失败！');
        }
    }
    //修改
    public function update($id){
        if(request()->isPost()){
            //dump(input('post.'));
            $data=input('post.');
            if($data['rules']) $data['rules']=implode(',',$data['rules']);
            $res=$this->getAuthGroupModel()->save($data,['id'=>$id]);
            if($res){
                $this->success('修改权限成功！','index','',1);
            }else{
                $this->error('修改权限失败！');
            }
        }else{
            $checked=$this->getAuthGroupModel()->find($id);
            $this->assign('sign',$checked);
            $data=db('manger')->select();
            $this->assign('data',$data);
            //规则显示
            $auth=new AuthRuleModel();
            $tree=$auth->authRuleTree();
            $this->assign('tree',$tree);
            return view();
        }
    }
}