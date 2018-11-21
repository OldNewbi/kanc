<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AuthRule as AuthRuleModel;
class AuthRule extends Controller{
    public function index(){
        $data=$this->getModel()->order('id')->select();
        $this->assign('data',$data);
        return view();
    }
    //把模型类返出来
    public function getModel(){
        return new AuthRuleModel();
    }
    //添加
    public function add(){
        if(request()->isPost()){
            //dump(input('post.'));
            $data=input('post.');
            if($data['pid']!=0){
                $level=$this->getModel()->where('id',$data['pid'])->field('level')->select();
                //dump($level[0]['level']);
                $data['level']=$level[0]['level']+1;
            }else{
                $data['level']=0;
            }
            $result=$this->getModel()->save($data);
            if($result){
                $this->success('添加规则成功！','index','',1);
            }else{
                $this->error('添加规则失败！');
            }
        }else{
            $aModel=new AuthRuleModel();
            $rule=$aModel->authRuleTree();
            $this->assign('rule',$rule);
            return view();
        }
    }
    //删除，如果删除的规则下面附带子规则的话，应当连子规则一并删除

    //前置操作
    protected $beforeActionList=['delSon'=>['only'=>'del']];

    public function delSon(){
        $id=input('id');
        $idx=$this->getModel()->getChild($id);
        if($idx){
            db('auth_rule')->delete($idx);
        }
    }

    public function del($id){
        $res=$this->getModel()->delA($id);
        if($res){
            $this->success('删除规则成功！','index','',1);
        }else{
            $this->error('删除规则失败！');
        }
    }

    //修改规则
    public function update($id){
        if(request()->isPost()){
            $data=input('post.');
            if($data['pid']!=0){
                $level=$this->getModel()->where('id',$data['pid'])->field('level')->select();
                //dump($level[0]['level']);
                $data['level']=$level[0]['level']+1;
            }else{
                $data['level']=0;
            }
            $result=$this->getModel()->save($data,['id'=>$id]);
            if($result){
                $this->success('修改规则成功！','index','',1);
            }else{
                $this->error('修改规则失败！');
            }
        }else{
            $data=$this->getModel()->find($id);
            $rule=$this->getModel()->authRuleTree();
            $this->assign(['data'=>$data,'rule'=>$rule]);
            return view();
        }
    }
}