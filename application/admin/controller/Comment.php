<?php


namespace app\admin\controller;

use app\admin\model\CommentModel;
use think\Db;

class Comment extends  Base
{
 public function  index(){
     $id=input('param.id');
   $comment=new CommentModel();
   $datas=$comment->where('forum_id','=',$id)->select();
   $data=$comment->sort($datas);
   $list=Db::table('up_user')->select();
//   var_dump($list);exit;
     $this->assign('list',$list);
     $this->assign('data',$data);
     return view('forum/comment');
 }
 public function del($id){
     $comment=new CommentModel();
     $res=$comment->where('id','=',$id)->delete();
     if($res){
         $this->success('删除成功','forum/coment');
     }else{
         $this->error('删除失败');
     }
 }
}