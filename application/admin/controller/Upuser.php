<?php


namespace app\admin\controller;

use think\Db;


class Upuser extends Base
{
  public function index(){
      $name = input('key');
      $user=new \app\admin\model\Upuser();
      if($name==''){

     $list=$user->paginate(8);
//      var_dump($data);
//
           }else{
          $list=$user->where('name','like',"%{$name}%")->paginate(8);
      }
      $this->assign('list',$list);
      return view();
  }
   public function user_status()
    {
        $user=new \app\admin\model\Upuser();
        $uid = input('param.id');

        $status =$user->where('id','=',$uid)->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag =$user->where('id','=',$uid)->setField(['status'=>0]);
            $this->success('已禁用','index');

        }
        else
        {
            $flag = $user->where('id','=',$uid)->setField(['status'=>1]);
            $this->success('已开启','index');
//            return ['code' => 0, 'data' => $flag['data'], 'msg' => '已开启'];
        }
    }

    public function user_is_home()
    {
        $user=new \app\admin\model\Upuser();
        $uid = input('param.id');

        $status =$user->where('id','=',$uid)->value('is_up');//判断当前状态情况
        if($status==1)
        {
            $flag =$user->where('id','=',$uid)->setField(['is_up'=>2]);
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