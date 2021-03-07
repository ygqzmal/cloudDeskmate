<?php
namespace app\index\model;
use think\Model;
class User extends Model{

	protected function getNameAttr($name,$date){
		return "name:" . $name . " ,age:" . $date['agess'];
	}
}