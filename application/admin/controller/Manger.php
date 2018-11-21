<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Manger as MangerModel;
class Manger extends Controller{
    //实例化模型类
    private function getModel(){
        $model=new MangerModel();
        return $model;
    }
    public function index(){
        $search=input('get.search');
        $map['username']=array("like","%{$search}%");
        $data=Db::table('manger')->where($map)->select();
        $count=Db::table('manger')->where($map)->count();
        $this->assign('data',$data);
        $this->assign('count',$count);
        return view();
    }
    //添加方法
    public function ajax_add(){
        parse_str(input('post.str'),$arr);
        //dump($arr);
        $model=new MangerModel();
        //使用验证器
        $validate=\think\Loader::validate('Manger');
        if(!$validate->scene('add')->check($arr)){
            return $arr=['error'=>$validate->getError(),'code'=>1];
        }else {
            $res = $model->addM($arr);
            if ($res) {
                $arr['id'] = $model->id;
                $arr['lastlogin'] = 0;
                $this->assign('dat', $arr);
                return view();
            }
        }
    }
    //删除
    public function ajax_del(){
        $arr=input('post.id');
        //$model=new MangerModel();
        $res=$this->getModel()->delM($arr);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //批量删除
    public function ajax_delAll(){
        $data=input('post.str');
        //dump($data);
        $res=$this->getModel()->delM($data);
        //$res=MangerModel::delM($data);
        return $res;
    }
    //更新查找
    public function ajax_upFind(){
        $id=input('post.id');
        $data=$this->getModel()->find($id);
        $data=$data->toArray();
        //dump($data);
        $this->assign('data',$data);
        return $this->fetch();
    }
    //更新用户
    public function ajax_edit(){
        parse_str(input('post.str'),$arr);
        //dump($arr);
        $res=$this->getModel()->editM($arr);
        if($res){
            $data=$this->getModel()->find($arr['id']);
            $data=$data->toArray();
            //dump($data);
            $this->assign('dat',$data);
            return $this->fetch();
        }else{
            echo 2;
        }
    }
    //用户状态的更改
    public function ajax_status(){
        $data=input('post.');
        $res=$this->getModel()->statusM($data);
        if($res) {
            $res = $res->toArray();
        }else{
            $res="error";
        }
        return $res;
    }
}