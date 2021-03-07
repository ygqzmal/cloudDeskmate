<?php
namespace app\ygq\validate;
use think\Validate;

class Community extends Validate
{
	protected $rule = [
		['title','require|max:10','标题不能为空|标题过长'], 
		['content','require|max:100','内容不能为空|内容过长'], 
	];
}