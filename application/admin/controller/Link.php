<?php

namespace app\admin\controller;

use think\Controller;

class Link extends Controller
{
	protected $db;
	public function _initialize(){
		parent::_initialize();
		$this->db = new \app\common\model\Link();//初始化模型
	}

	//友链首页
    public function index(){
    	$feild = $this->db->getAll();
    	$this->assign('feild',$feild);
    	return $this->fetch();
    }

    //添加友链、编辑
    public function store(){
    	$link_id = input('param.link_id');
    	if(request()->isPost()){
    		$res = $this->db->store(input('post.'));
    		if($res['valid']){
    			//添加成功
    			$this->success($res['msg'],'index');
    			exit;
    		}else{
    			//添加失败
    			$this->error($res['msg']);
    			exit;
    		}
    	}
    	if($link_id){
    		$oldData = $this->db->find($link_id);
    		
    	}else{
    		$oldData = ['link_name'=>'','link_url'=>'','link_sort'=>100];
    	}
    	$this->assign('oldData',$oldData);
    	return $this->fetch();
    }

    /**
     *友链删除
     */
    public function del(){
    	$link_id = input('get.link_id');
    	if(\app\common\model\link::destroy($link_id)){
    		$this->success('操作成功','index');
    		exit;
    	}else{
    		$this->error('操作失败');
    		exit;
    	}
    }

}
