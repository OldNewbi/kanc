<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Lunbo as LunboModel;
class Lunbo extends Controller{
    public function index(){
        $search=input('get.search');
        $map['href']=array('like',"%{$search}%");
        $data=db('lunbo')->where($map)->select();
        $count=db('lunbo')->where($map)->count();
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    //上传轮播
    public function ajax_upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move('./static/uploads');
            if($info){
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
    //添加轮播
    public function add(){
        //实例化模型
        $LunboModel=new LunboModel();
        //验证
        $validate=\think\Loader::validate('Lunbo');
        if(!$validate->scene('add')->check(input('post.'))){
            $this->error($validate->getError());
        }
        $res=$LunboModel->addL(input('post.'));
        if($res){
            $this->success('添加成功！','index','',1);
        }else{
            $this->error('添加失败！');
        }
        //dump(input('post.'));
    }
    //删除轮播
    public function del($id){
        //dump($id);
        $LunboModel=new LunboModel();
        $res=$LunboModel->delL($id);
        if($res){
            $this->success('删除成功！','index','',1);
        }else{
            $this->error('删除失败！');
        }
    }
    //修改轮播
    public function update($id){
        if(request()->isPost()){
            //dump(input('post.'));
            $data=input('post.');
            if($data['img']){
                if(file_exists("./static/uploads/{$data['oldImg']}"))
                unlink("./static/uploads/{$data['oldImg']}");
            }else{
                $data['img']=$data['oldImg'];
            }
            unset($data['oldImg']);
            $lunbo=new LunboModel();
            $res=$lunbo->save($data,['id'=>$id]);
            if($res){
                $this->success('修改成功!','index','',1);
            }else{
                $this->error('删除失败！');
            }
        }else {
            $data = db('lunbo')->find($id);
            $this->assign('dat', $data);
            return view();
        }
    }
    //轮播排序
    public function sort(){
        //dump(input('post.'));
        $data=input('post.');
        $res=db('lunbo')->where(['id'=>$data['id']])->update(['sort'=>$data['sort']]);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //批量删除
    public function delAll($id){
        $lunbo=new LunboModel();
        $list=$lunbo::all($id);
        $res=$lunbo::destroy($id);
        if($res){
            foreach ($list as $v){
                $file="./static/uploads/{$v['img']}";
                if(file_exists($file)) unlink($file);
            }
            $this->success('删除成功！','index','','1');
        }else{
            $this->error('删除失败！');
        }
    }
}