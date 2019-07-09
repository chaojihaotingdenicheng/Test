<?php


namespace app\admin\controller;


use think\Request;
use think\Controller;
use think\Db;
use app\admin\model\Tet;
class Test extends Controller
{
    public function index()
    {
        $data=Db::table("up_user")
            ->field("up_user.name,up_forum .info")
            ->join("up_forum","up_user.id=up_forum.user_id")
            ->paginate(10);
          $this->assign('data',$data);
        return view();
    }
    public function user(){
        $data=Db::table('up_user')->select();
        return json([
            'code'=>'1','data'=>$data,'maessage'=>'success'
        ]);
    }
    public function add(){
        if (request()->isPost()){
            $data=input('post.');
           var_dump($data);
        }
    }
    public function read($id){
        $data=Db::table('up_user')->where('id','=',$id)->select();
        return json(['code'=>'1','msg'=>'成功','data'=>$data]);
    }
    public function del($id){
        $res=Db::table('tet')->where('id','=',$id)->delete();
        return json($res);
    }
    public function update(Request $request,$id){
        $data=Db::table('tet')->where('id','=',$id)->find();
        $res=Db::table('tet')->where('id','=',$id)->update();
        return json($res);
    }
}