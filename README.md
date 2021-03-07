


@[TOC](PHP TP5实战云同桌小程序)


<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">

# 前言

<font color=#999AAA >参加腾讯小程序比赛，和工作室前端小伙伴一起组队完成了这个云同桌小程序。本人负责该项目后端，主要使用PHP的thinkphp5框架来完成，数据库使用mysql；将码云连接放到文末，相关代码在application下的ygq文件中。</font>

<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">

<font color=#999AAA >

# 一、TP5是什么？


<font color=#999AAA >ThinkPHP是一个快速、简单的基于MVC和面向对象的轻量级PHP开发框架，为WEB应用和API开发提供了强有力的支持。作为php开发者必学的一个框架。





# 二、使用
## 1.mvc思想
![主要遵循mvc思想](https://img-blog.csdnimg.cn/20210307224833529.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3dlaXhpbl80NTE2NjUxMQ==,size_16,color_FFFFFF,t_70#pic_center)主要遵循mvc思想，controller层主要负责view层传来的请求，正真对数据库进行操作的是model层，由于逻辑相对复杂，因此引入TP5框架自带的验证器也就是逻辑层，用于数据的校验与判断。可以实现每层代码量相对减少，逻辑清晰易懂。



<font color=#999AAA >控制层代码如下（示例）：



```c
<?php
namespace app\ygq\controller;
use think\Controller;
use app\ygq\model\User as UserModel;
use app\ygq\model\Sign as SignModel;
use think\Request;
use think\Session;
//个人信息
class User extends Controller{
	//展示个人信息
	public function index(){
		$user = UserModel::get(Session::get('user_id'));
		$sign = SignModel::all(['uid'=>Session::get('user_id')]);
		$user['sign'] = $sign;
		return json($user);
	}
	//用户数据获取(头像和昵称)
	public function addUser(){
		$data = input('post.');
		$ret  = UserModel::getByName($data['name']);
		if($ret){
			//return'用户已经注册';
			Session::set('user_id',$ret['id']);
			return json(['success'=>'登录成功'],200);
		}else{
			//return '用户还没注册';
			$user    = new UserModel;
			$request = Request::instance();
			$file    = $request->file('image');
			$info    = $file->rule('date')->move(ROOT_PATH.'public'.DS.'uploads');
			$data['image'] = $info->getRealPath();
			if($user->allowField(true)->save($data)){
				Session::set('user_id',$ret['id']);
            	return json(['success'=>'登录成功'],200);
        	}else{
            	return json(['error'=>'登录失败'],404);
        	}
		}
	}
	//个人介绍更新和添加
	public function addIntor(){
		$id   = Session::get('user_id');
        $data = input('post.');
		if(strlen($data['introduce']) > 100){
			return json(['error'=>'字数超出规定'],404);
		}
        if(UserModel::update($data,['id'=>$id])){
            return json(['success'=>'介绍添加成功'],200);
        }else{
            return json(['error'=>'介绍添加失败'],404);
        }
	}
	//每点一个标签就调用一次这个方法
	public function addSign(){
		$uid = Session::get('user_id');
		$ret = SignModel::where('uid','=',$uid)->select();
		if(count($ret) >= 4){
			return json(['error'=>'标签最多选4个'],404);
		}
        $data = input('post.');
        $data['uid'] = $uid;
        if(SignModel::create($data)){
            return json(['success'=>'标签添加成功'],200);
        }else{
            return json(['error'=>'标签添加失败'],404);
        }
	}
	//标签删除
	public function delSign($id){
        if(SignModel::destroy($id)){
            return json(['success'=>'记录删除成功'],200);
        }else{
            return json(['error'=>'记录删除失败'],404);
        }
	}
}
```

## 2.感受
thinkphp框架使用起来并不困难，对于初学者第一次接触框架的同学来说，还是比较友好，主要体现在易安装，开发web应用简单明了，教学资料丰富上，网上第三方库也成熟，便于引用。至于运用程度，自然是熟能生巧。不过也有一些缺点，个人感觉对比起golang的beego、gin框架，代码不够简练，有单复杂，个人更喜欢beego一些。

# 总结
<font color=#999AAA >php属于弱类型语言，相比起其他语言来说还是比较简单的，个人感觉php更适于轻量级web开发，开发速度快，php学习上手快，php基础不会太难。但php可能遇到高并发的时候会陷入瓶颈，难以突破。最后将代码连接放出来。

[码云代码连接地址](https://gitee.com/ygqzmal/php)