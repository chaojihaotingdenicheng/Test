<?php


namespace app\admin\model;


use think\Db;
use think\Model;

class CommentModel extends Model
{
   protected $table='up_forum_comment';
public function typetree(){
    $data=$this->select();

    return $this->sort($data);
}

public function sort($cate,$leve=0,$pid=0){
    static $arr=array();
    foreach ($cate as $key =>$value){
        if ($value['pid']==$pid){
            $value['leve']=$leve;
            $arr[]=$value;
            $this->sort($cate,$leve+1,$value['id']);
        }
    }
    return $arr;
}
}
