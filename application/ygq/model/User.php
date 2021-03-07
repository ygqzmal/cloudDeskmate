<?php

namespace app\ygq\model;
use think\Model;

class User extends Model{

	public function sign(){
		return $this->hasOne('Sign','uid','id');
	}
	
}
