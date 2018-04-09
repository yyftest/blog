<?php
namespace app\admin\controller;
use app\common\model\Admin;
use houdunwang\crypt\Crypt;
use think\Controller;

class Login extends Controller{
	public function index(){
		//echo Crypt::encrypt('admin888');//加密：h3vPU8JGuF3VS/uxIpjRSw==
		//echo Crypt::decrypt('h3vPU8JGuF3VS/uxIpjRSw==');//解密：admin888
		//$data = db('admin')->find(1);
		//dump($data);

		if(request()->isPost()){//post接受数据
			$res = (new Admin())->login(input('post.'));
			//halt($res);
			if($res['valid']){
				//登录成功，跳转
				$this->success($res['msg'],'admin/entry/index');
				exit;
			}else{
				//登录失败
				$this->error($res['msg']);
				exit;
			}
		}

		//加载登录页面
		return $this->fetch('index');
	}












}