<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Author as AuthorModel;
class Author extends Controller{
    public function index(){
        $search=input('get.search');
        $map['name']=array('like',"%{$search}%");
        $data=db('author')->where($map)->select();
        $count=db('author')->where($map)->count();
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
        $LunboModel=new AuthorModel();
        //验证
        $validate=\think\Loader::validate('Author');
        if(!$validate->scene('add')->check(input('post.'))){
            $this->error($validate->getError());
        }
        $res=$LunboModel->addA(input('post.'));
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
        $LunboModel=new AuthorModel();
        $res=$LunboModel->delA($id);
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
            $file="./static/uploads/{$data['oldImg']}";
            if($data['photo']){
                if(file_exists($file))
                    unlink($file);
            }else{
                $data['photo']=$data['oldImg'];
            }
            unset($data['oldImg']);
            $lunbo=new AuthorModel();
            $res=$lunbo->save($data,['id'=>$id]);
            if($res){
                $this->success('修改成功!','index','',1);
            }else{
                $this->error('删除失败！');
            }
        }else {
            $data = db('author')->find($id);
            $this->assign('dat', $data);
            return view();
        }
    }

    //批量删除
    public function delAll($id){
        $lunbo=new AuthorModel();
        $list=$lunbo::all($id);
        $res=$lunbo::destroy($id);
        if($res){
            foreach ($list as $v){
                $file="./static/uploads/{$v['photo']}";
                if(file_exists($file)) unlink($file);
            }
            $this->success('删除成功！','index','','1');
        }else{
            $this->error('删除失败！');
        }
    }
}