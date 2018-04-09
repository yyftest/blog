<?php

namespace app\admin\controller;

use think\Controller;

class Tag extends Controller
{
	protected $db;
	public function _initialize(){
		parent::_initialize();//初始化模型
		$this->db = new \app\common\model\Tag();
	}

    //标签列表
    public function index(){
    	//获取首页数据
    	$field = db('tag')->paginate(10);//分页
    	$this->assign('field',$field);
    	return $this->fetch();
    }

    //添加标签
    public function store(){
    	$tag_id = input('param.tag_id');

    	if(request()->isPost()){
    		$res = $this->db->store(input('post.'));
    		if($res['valid']){
    			//成功
    			$this->success($res['msg'],'index');
    			exit;
    		}else{
    			//失败
    			$this->error($res['msg']);
    			exit;
    		}
    	}
    	if($tag_id){
    		//说明是编辑操作
    		$oldData = $this->db->find($tag_id);
    			//halt($oldData);
    	}else{
    		//添加操作
    		$oldData = ['tag_name'=>''];
    	}
    	$this->assign('oldData',$oldData);
    	return $this->fetch();
    }

    /**
     * 删除标签
     */
    public function del(){
    	$tag_id = input('get.tag_id');
    	//执行删除
    	if(\app\common\model\Tag::destroy($tag_id)){
    		//成功提示
    		$this->success('操作成功','index');
    		exit;
    	}else{
    		//失败提示
    		$this->error('操作失败');
    		exit;
    	}
    }







}
