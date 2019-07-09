<?php


namespace app\admin\controller;

use app\admin\model\Types;
use think\Db;
use think\Request;
use app\admin\model\Typed;



class Type extends Base
{
     public function index(){
         $type=new Typed();
        $name = input('key');
        if($name==''){
         $list=$type->typetree();
        }
       else{
         $lis=Db::table('up_task_type')->where('name','like',"%{$name}%")->select();
         $list=$type->sort($lis);
   
       }
         $data=Db::table('up_industry')->select();
         $this->assign('data',$data);
         $this->assign('list',$list);
         return view();
     }
//
      public function  eee(){
         $data=Db::query('insert into up_task_type ()');
      }
     public function add(){
//       $data=Request::instance()->except('_method');
         $type=new Types();
         if(request()->isPost()){
             $data=input('post.');
                if ($_FILES['img']['tmp_name']) {
                     $file = request()->file('img');
                      if($file){
                              $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                              if($info){
                                  $img= '/uploads/'.$info->getSaveName();
                                  $data['pic']=$img;
                               }
                       }
             } 
          
             $res=$type->save($data);

             if($res){

                $this->success('添加成功','add');

             }else{

                $this->error('添加失败');
             }
         }
        $typed=new Typed();
         $types=$typed->typetree();
         $data=Db::table('up_industry')->select();
         $this->assign('data',$data);
         $this->assign('list',$types);
         return view();
     }
     public function edit($id){
         $list=Db::query('select * from up_task_type where id=?',[$id]);
         $this->assign('list',$list[0]);
         return view();
     }
    public function update(Request $request,$id){
         $type=new Types();
        $data=$request->param();
//        var_dump($data);exit;
        $res=$type->save($data,$id);
        if($res){
            $this->success('编辑成功','index');
        }else{
            $this->error('编辑失败');
        }

    }
    public function delete($id){
        $data=Request::instance()->except('_mothod');
//       var_dump($data);
        $res=Db::execute('delete from up_task_type where id=:id',$data);
        if($res){
            $this->success('删除成功','index');
        }else{
            $this->error('删除失败');
        }
    }
    public function user_is_up()
    {
        $user=new Typed;
        $uid = input('param.id');

        $status =$user->where('id','=',$uid)->value('is_up');//判断当前状态情况
        if($status==1)
        {
            $flag =$user->where('id','=',$uid)->setField(['is_up'=>0]);
            $this->redirect('index');
        }
        else
        {
            $flag = $user->where('id','=',$uid)->setField(['is_up'=>1]);
            $this->redirect('index');
//            return ['code' => 0, 'data' => $flag['data'], 'msg' => '已开启'];
        }
    }

}