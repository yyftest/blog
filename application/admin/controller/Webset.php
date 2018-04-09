<?php

namespace app\admin\controller;

use think\Controller;

class Webset extends Controller
{
	//首页
    public function index(){
    	//获取数据
    	$feild = db('webset')->select();
    	$this->assign('feild',$feild);
    	return $this->fetch();
    }

    //网站配置编辑
    public function edit(){
    	if(request()->isAjax()){
    		//halt($_POST);
    		$res = (new \app\common\model\Webset())->edit(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');
    			exit;
    		}else{
    			$this->error($res['msg']);
    			exit;
    		}
    	}
    }
}
