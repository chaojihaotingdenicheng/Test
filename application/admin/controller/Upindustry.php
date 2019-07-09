<?php


namespace app\admin\controller;


use app\admin\model\Industry;
use think\Db;
use think\Request;

class Upindustry extends  Base
{
   public function index(){
    $list=Db::table('up_industry')->select();

     foreach ($list as $key => &$value){

         $value['res']=Db::table('up_profession')->where("industry_id=$value[id]")->select();
     }

   $this->assign('list',$list);

  return view();
   }
   public function add(){
//      $data=Request::instance()->except('_mothod');
       if (request()->isPost()){
           $data=input('post.');
           $info=$data['info'];
           $industry_id=$data['industry_id'];
           $create_time=$data['create_time'];
           $user=new Industry();
           $user->data([
               'info'=>$info,
               'industry_id'=>$industry_id,
               'create_time'=>$create_time
           ]);
           $res= $user->save($data);
        if($res>0){
            $this->success('添加成功','index');
        }else{
            $this->error('添加失败');
        }
       }
//      var_dump($data);

       return view();
   }
   public function edit($id){
//       var_dump($industry_id);
     $list=Db::query('select * from up_profession where id=?',[$id]);
     $this->assign('list',$list[0]);
       return view();
   }
   public function update(Request $request,$id){
      $data= Request::instance()->except('_mothod');
//      var_dump($data);
       $res=Db::execute('update up_profession set info=:info,industry_id=:industry_id where id=:id',$data);
       if($res){
           $this->success('编辑成功','index');
       }else{
           $this->error('编辑失败');
       }

   }
   public function delete($id){
       $data=Request::instance()->except('_mothod');
//       var_dump($data);
       $res=Db::execute('delete from up_profession where id=:id',$data);
       if($res){
           $this->success('删除成功','index');
       }else{
           $this->error('删除失败');
       }
   }
}