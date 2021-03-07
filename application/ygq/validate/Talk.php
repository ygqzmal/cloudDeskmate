<?php
namespace app\ygq\validate;
use think\Validate;

class Talk extends Validate
{
	protected $rule = [ 
		['content','require|max:100','内容不能为空|内容过长'], 
	];
}