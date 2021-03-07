<?php
namespace app\ygq\controller;
use think\Controller;
use app\ygq\model\Community as CommunityModel;
use app\ygq\model\Sign as SignModel;
use app\ygq\model\User as UserModel;
use app\ygq\model\Talk as TalkModel;
use think\Request;
use think\Session;
//个人信息
class community extends Controller{
	//展示小区信息
	public function index(){
		$data = array();
		$list = CommunityModel::paginate(5);
		//$list = CommunityModel::all();
		//$list = CommunityModel::where('id','>',1);//->paginate(5);
		//return json($list);
		foreach ($list as $value) {
			//$data[] = $value;
			//return $data;
			//return $value;
			$uid  = $value->uid;
			$data = CommunityModel::get($uid,'user');
			$value['name']  = $data->user->introduce;
			$value['image'] = $data->user->image;
			$value['sign']  = SignModel::all(['uid'=>Session::get('user_id')]);
			//$data[$key] = $value;
			print_r("<br>"."----------");
			print_r(json($value));
		}
		//return $data;
	}
	//小区帖子添加
	public function add(){
		$comm = new CommunityModel;
		$data = input('post.');
		$data['uid'] = Session::get('user_id');
		if($comm->allowField(true)->validate(true)->save($data)){
            return json(['success'=>'信息发布成功'],200);
        }else{
            return json($comm->getError(),404);
        }
	}
	//私信界面
	public function send(){
		return json(UserModel::get(input('get.rid'))['name']);
	}
	//私信发送
	public function sendMessage(){
		$data = input('post.');
		$data['sid'] = Session::get('user_id');
		if($data['sid'] == input('post.rid')){
			return json(['error'=>'非法操作'],404);
		}
		$data['time'] = date('Y-m-d H:i:s',time());
		$talk = new TalkModel;
		if($talk->allowField(true)->validate(true)->save($data)){
            return json(['success'=>'消息发送成功'],200);
        }else{
            return json($talk->getError(),404);
        }
	}
	//消息接收界面
	public function receive(){
		$data = array();
		$data['read'] = count(TalkModel::all(['status'=>0]));
		$uid = Session::get('user_id');
		$list = TalkModel::where('rid','=',$uid)->paginate(5);
		foreach ($list as $value) {
			$value['name'] = UserModel::get($value['sid'])['name'];
			$value['image'] = UserModel::get($value['sid'])['image'];
			$data[] = $value;
		}
		return json($data);
	}
	//查看某个消息
	public function read(){
		$id = input('get.id');
		$data = TalkModel::get($id);
		if($data['status'] == 0){
			$data->status = 1;
			$data->save();
		}
		return json($data);
	}
}