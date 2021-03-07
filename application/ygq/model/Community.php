<?php

namespace app\ygq\model;
use think\Model;

class community extends Model{
	
	public function user(){
		return $this->hasOne('User','id','uid');
	}
	
}
