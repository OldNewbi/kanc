<?php
namespace app\admin\model;
use think\Model;
class Article extends Model{
    protected static function init(){
        Article::event('before_insert',function($ArticleModel){
            if($_FILES['img']['tmp_name']){
                $file=request()->file('img');
                $info=$file->move('./static/uploads/article');
                if($info){
                    $ArticleModel['img']=$info->getSaveName();
                }else{
                    return $file->getError();
                }
            }
        });
    }
    //删除
    public function delA($id){
        $data=$this->field('img')->find($id);
        //dump($data['img']);
        $file="./static/uploads/article/{$data['img']}";
        if(file_exists($file)) unlink($file);
        return $this::destroy($id);
    }
}
