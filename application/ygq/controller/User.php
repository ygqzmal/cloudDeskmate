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