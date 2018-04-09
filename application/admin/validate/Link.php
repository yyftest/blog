<?php
namespace app\admin\validate;
use think\validate;

class Link extends Validate{
	protected $rule = [
		'link_name'=>'require',
		'link_url'=>'require',
		'link_sort'=>'require|between:1,9999',
	];

	protected $message =[
		'link_name.require'=>'请输入链接名称',
		'link_url.require'=>'请输入链接地址',
		'link_sort.require'=>'请输入链接排序',
		'link_sort.between'=>'排序需在1-9999之间',
	];
}

