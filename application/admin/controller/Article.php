<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Colum;
use app\admin\model\Article as ArticleModel;
class Article extends Controller{
    public function index(){
        $data=db('article')->alias('a')->join('colum b','a.columid=b.id')->join('author c','a.authorid=c.id')->field('a.*,b.name cname,c.name')->paginate(2);
        $page=$data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        return $this->fetch();
    }
    //显示正文
    public function detail($id){
        //dump($id);
        $article=new ArticleModel();
        $data=$article->field('content')->find($id);
        $this->assign('data',$data);
        return view();
    }
    //添加页面
    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            $article=new ArticleModel();
            $data['time']=time();
            //dump($data);
            $res=$article->save($data);
            if($res){
                $this->success('添加文章成功！','index','',1);
            }else{
                $this->error('添加文章失败！');
            }
        }else{
            //显示栏目、作者
            $colum = new Colum();
            $col = $colum->colTree();
            $author = db('author')->select();
            $this->assign(array(
                'col' => $col,
                'author' => $author
            ));
            return view();
        }
    }
    //删除
    public function del($id){
        //dump($id);
        $article=new ArticleModel();
        $res=$article->delA($id);
        if($res){
            $this->success('删除文章成功','index','',1);
        }else{
            $this->error('删除文章失败');
        }
    }
    //修改
    public function update($id){
        if(request()->isPost()){
            //dump(input('post.'));
            $data=input('post.');
            $articleModel=new ArticleModel();
            if($_FILES['img']['tmp_name']){
                $file=request()->file('img');
                $info=$file->move('./static/uploads/article');
                if($info){
                    unlink("./static/uploads/article/{$data['img']}");
                    $data['img']=$info->getSaveName();
                }else{
                    $this->error($file->getError());
                }
            }
            $data['time']=time();
            $res=$articleModel->save($data,['id'=>$id]);
            if($res){
                $this->success('修改文章成功！','index','',1);
            }else{
                $this->error('修改文章失败！');
            }
        }else{
            //显示绑定id的数据
            $articleModel=new ArticleModel();
            $articleData=$articleModel->find($id);
            $this->assign('aData',$articleData);
            $col=new Colum();
            $data=$col->colTree();
            $author=db('author')->select();
            $this->assign(array(
                'col'=>$data,
                'author'=>$author
            ));
            return $this->fetch();
        }
    }
}