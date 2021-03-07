<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Url;
use app\index\model\Users;
use app\index\model\UserLevel;
use app\index\model\Test;
use app\index\model\Comment;
use think\Validate;
class User extends Controller
{
    

    public function test19()
    {
//       $user = Users::get(1);
        // 获取User对象的nickname属性
//        echo $user->nickname."<br/>";
//        // 获取User对象的comm关联对象
//         $user->comm;         
       //foreach($user->comm as $comm)
        //   echo "评论id: {$comm->comment_id} 用户评论内容: {$comm->content}<br/>"; 
        // 执行关联的comm对象的查询  获取User对象的comm关联对象
//        $comm = $user->comm()->where('content','这东西不错,下次还会来买')->find();        
//        echo "评论id: {$comm->comment_id} 用户评论内容: {$comm->content}<br/>";         
                
//            // 一对多关联新增
//            $user = Users::get(1);
//            $comment = new Comment;
//            $comment->content  = 'ThinkPHP5视频教程';
//            $comment->add_time = time();
//            $user->comm()->save($comment);
//            return '添加评论成功';        
//            
            // 一对多批量新增
//            $user  = Users::get(1);
//            $comment = [
//                ['content' => 'ThinkPHP5视频教程', 'add_time' =>time()],
//                ['content' => 'TP5视频教程', 'add_time' => time()],
//            ];
//            $user->comm()->saveAll($comment);
//            return '添加comm成功';     
            
            // 关联查询
//                $user  = Users::get(1); // Users::get(1,'comm');
//                $comm = $user->comm;
//                dump($comm);        
        
            // 关联过滤查询
//            $user  = Users::get(1);
            // 获取状态为1的关联数据
          //  $comment = $user->comm()->where('is_show',1)->select();              
            //dump($comment);
//        foreach($comment as $comm)
//            echo "评论id: {$comm->comment_id} 用户评论内容: {$comm->content}<br/>";             
            
//            $comm  = $user->comm()->getByContent('ThinkPHP5视频教程');
//            echo "评论id: {$comm->comment_id} 用户评论内容: {$comm->content}<br/>";             
        
            // 根据关联数据来查询当前模型数据
            // 查询有评论过的用户列表
            //$user = Users::has('comm')->select();
            // 查询评论过2次以上的用户
            //$user = Users::has('comm', '>=', 2)->select();
            // 查询评论内容含有 ThinkPHP5快速入门的用户
            //$user = Users::hasWhere('comm', ['content' => 'ThinkPHP5视频教程'])->select();            
     
            // 关联更新 
//            $user = Users::get(1);
//            $comm = $user->comm()->getByContent('ThinkPHP5视频教程');
//            $comm->content = 'ThinkPHP5快速入门';
//            $comm->save();            
//            
              //查询构建器的update方法进行更新
//                $user = Users::get(1);
//                $user->comm()->where('content', 'ThinkPHP5快速入门')->update(['content' => 'ThinkPHP5开发手册']);            
            
             // 删除部分关联数据
//                $user = Users::get(1);
//                // 删除部分关联数据
//                $comm = $user->comm()->getByContent('ThinkPHP5开发手册');
//                $comm->delete();   
            
//            //删除所有的关联数据：
//            $user = Users::get(1);             
//            // 删除所有的关联数据
//            $user->comm()->delete();           
            

        // 轿车  一对一案例
       //  $user = Users::get(1);
//        echo "车品牌: ". $user->car->brand. " 车牌号:".$user->car->plate_number ."<br/>";
       
//        // 新增用户 关联 汽车
//        $user = new Users;
//        $user->email = '123456@1243.com';
//        $user->nickname = 'TPshop';
//        $user->password = '123456789';
//        if($user->save()){
//            $car['brand'] = '奔驰';
//            $car['plate_number'] = '粤A12345678';
//            //uid 不指定
//            $user->car()->save($car); // Relation对象  添加一部车
//            return '用户[ ' . $user->nickname . ' ]新增成功';
//        } else {
//            return $user->getError();
//        }   
        
        // 关联查询 
//            $user = Users::get(2600); // $user = Users::get(2600,'car');
//            echo $user->email . '<br/>';
//            echo $user->nickname . '<br/>';
//            echo $user->car->brand . '<br/>';
//            echo $user->car->plate_number . '<br/>';        
//         // 关联更新
//            $user = Users::get(1);
//            $user->email = 'TPshop@qq.com';
//            if ($user->save()) {
//                // 更新关联数据
//                $user->car->plate_number = '粤B123466';
//                $user->car->save();
//                return '用户[ ' . $user->email . ' ]更新成功';
//            } else {
//                return $user->getError();
//            }        
        // 关联删除
//        $user = Users::get(2600);
//        if ($user->delete()) {
//            // 删除关联数据
//            $user->car->delete();
//            return '用户[ ' . $user->email . ' ]删除成功';
//        } else {
//            return $user->getError();
//        }              
            
    }

//   // 创建用户数据页面
//    public function create()
//    {
//        //return view();
//        return view("user/create");
//    } 
//    
//    // 新增用户数据
//    public function add()
//    {
//        // 自动收集表单数据 input('post.') 
//        // 自动排除不相关字段
//        // 自动校验非法字段
//        // 自动生成 insert 语句 执行入库        
//        $users = new Users;
//        if ($users->allowField(true)->validate(true)->save(input('post.'))) {
//            return '用户[ ' . $users->nickname . ':' . $users->user_id . ' ]新增成功';
//        } else {
//            return $users->getError();
//        }
//    }
     // 控制器验证
    public function add()
    {
        $data = input('post.');
        // 数据验证
        $result = $this->validate($data,'Users');
        if (true !== $result) {
            return $result;
        }
        $users = new Users;
        // 数据保存
        $users->allowField(true)->save($data);
        return '用户[ ' . $users->nickname . ':' . $users->user_id . ' ]新增成功';
    }    
      //  单独验证 某 字段
//    public function add()
//    {
//        $data  = input('post.');
//        // 验证birthday是否有效的日期
//        $check = Validate::is($data['birthday'],'date');
//        if (false === $check) {
//            return 'birthday日期格式非法';
//        }
//        $users = new Users;
//        // 数据保存
//        $users->allowField(true)->save($data);
//        return '用户[ ' . $users->nickname . ':' . $users->user_id . ' ]新增成功';
//    }        
}
