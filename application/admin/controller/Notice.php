<?php


namespace app\admin\controller;

use app\admin\model\NoticeModel;
use think\Db;
use think\Request;

class Notice extends Base
{
   public function index(){
       $list=Db::table('up_notice')->select();
       $this->assign('list',$list);
       return view();
   }
   public function add(){
    $notice=new NoticeModel();
    if(request()->isPost()){
        $data=input('post.');
        $res=$notice->save($data);
        if ($res){
            $this->success('添加成功','index');
        }else{
            $this->error('添加失败');
        }

    }
    return view();
   }
   public function edit($id){
       $list=Db::query('select * from up_notice where id=?',[$id]);
      $this->assign('list',$list[0]);
      return view();
   }
   public function update(Request $request,$id){
       $data=$request->param();
       $notice=new NoticeModel();
       $res=$notice->save($data,['id'=>$id]);
       if ($res){
           $this->success('编辑成功','index');
       }else{
           $this->error('编辑失败');
       }
   }
   public function delete($id){
       $notice=new NoticeModel();
       $res=$notice->where('id','=',$id)->delete();
       if ($res){
           $this->success('删除成功','index');
       }else{
           $this->error('删除失败');
       }

   }
}