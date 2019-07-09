<?php


namespace app\admin\model;


use think\Model;

class Forum extends Model
{
     protected $table='up_forum';
//     protected static function init()
//     {
//         Forum::event('before_insert', function ($forum) {
//            if ($_FILES['img']['tmp_name']) {
//              $file = request()->file('img');
//              // var_dump($file);die;
//               if($file){
//                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//               if($info){
//              $img=$info->getExtension();
//              $forum['img']=$img;
//            }
//          }
//          }

//         });
    
// }

    public function insertforum($param)
    {
        try{
            $result = $this->allowField(true)->save($param);
            if(false === $result){
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '动态添加成功'];
            }
        }catch( \PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
  public function updateforum($param){
      try{
          $result = $this->allowField(true)->save($param, ['id' => $param['id']]);
          if(false === $result){
              return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
          }else{
              return ['code' => 1, 'data' => '', 'msg' => '动态编辑成功'];
          }
      }catch( \PDOException $e){
          return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
      }
  }
    public function delForum($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '动态删除成功'];
        }catch( \PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}