<?php


namespace app\admin\controller;

use think\Db;
use think\Request;



class Forum extends Base
{
    public function index(){
        $info = input('key');
//        $forum=new \app\admin\model\Forum();
        if($info==''){

            $list=Db::table('up_user')
                ->field('up_user.name,up_forum.*')
                ->join('up_forum','up_user.id=up_forum.user_id')
                ->paginate(10);

//      var_dump($data);
//
        }else{
                $list=Db::table('up_user')
                ->field('up_user.name,up_forum.*')
                ->join('up_forum','up_user.id=up_forum.user_id')
                ->where('up_forum.info|up_user.name','like',"%".$info."%")
                ->paginate(8);

        }
        // foreach ($list as $key => $value) {
        //     # code...
        //     var_dump($value);exit;
        // }
//        $uid=Db::query('select user_id from up_forum');
//        foreach ($uid as $key => $value) {
//            foreach ($value as $key => $value1) {
//            $user=Db::table('up_user')->where('id','=',$value1)->select();
//            // var_dump($user);exit;
//             $this->assign('user',$user);
//               }
//        }
       
        $this->assign('list',$list);
    return view();

    }
    
    public function add(){
        if(request()->ispost()){
            $data = input('post.');
            $forum = new \app\admin\model\Forum();
             if ($_FILES['img']['tmp_name']) {
                     $file = request()->file('img');
                      if($file){
                              $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                              if($info){
                                  $img=  '/uploads/'.$info->getSaveName();
                                  $data['img']=$img;
                               }
                       }
             } 

            $res=$forum->save($data);

            // var_dump(2222222222);exit;
            // var_dump($res);die;
            if ($res) {
              $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }

        return view();
    }
    public function update(Request $request,$id){
        $data= Request::instance()->except('id');
        $forum=new \app\admin\model\Forum();
          if ($_FILES['img']['tmp_name']) {
             $file = request()->file('img');
              if($file){
               $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
              if($info){
             $img= '/uploads/'.$info->getExtension();
             $data['img']=$img;
           }
         }
     }
        $res=$forum->save($data,['id'=>$id]);

        if($res){
            $this->success('编辑成功','index');
        }else{
            $this->error('编辑失败');
        }
    }
    public function edit($id){
//        if (request()->isAjax()){
//            $param=input('post.');
//            $forum=new \app\admin\model\Forum();
//            $flag=$forum->updateforum($param);
//            return json(['code'=>$flag['code'],'data'=>$flag['code'],'msg'=>$flag['msg']]);
//        }
       // $id=input('param.id');
        // $forum=new \app\admin\model\Forum();
        $list=Db::query('select * from up_forum where id=?',[$id]);
       // $list=$forum->where('id','=',$id)->select();
       // var_dump($list);exit;
        $this->assign('list',$list[0]);
        return view('edits');
    }
    public function del($id){
       $data=Request::instance()->except('_method');
        $res=Db::execute('delete from up_forum where id=:id',$data);
        if ($res){
            $this->success('删除成功','index');
        }else{
            $this->error('删除失败');
        }
//        $forum=new \app\admin\model\Forum();
//        $result = $forum->delForum($uid);
//
    }
    public function user_status(){
        $user=new \app\admin\model\Forum();
        $uid = input('param.id');

        $status =$user->where('id','=',$uid)->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag =$user->where('id','=',$uid)->setField(['status'=>2]);
          $this->redirect('index');

        }
       elseif ($status==0)
        {
            $flag = $user->where('id','=',$uid)->setField(['status'=>1]);
          $this->redirect('index');
        }
        else{
            $flag = $user->where('id','=',$uid)->setField(['status'=>0]);
            $this->redirect('index');
        }
    }

}