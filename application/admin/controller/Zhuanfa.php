<?php


namespace app\admin\controller;


use think\Db;

class Zhuanfa extends Base
{
 public function index($id){
   $data=Db::table('up_forum_relay')->where('forum_id','=',$id)->select();
   $list=Db::table('up_user')->select();
   $this->assign('list',$list);
   $this->assign('data',$data);
    return view('forum/zhuanfa');
 }
}