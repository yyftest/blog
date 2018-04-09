<?php

namespace app\admin\controller;
use app\common\model\Category;
use think\Controller;

class Article extends Controller
{

	protected $db;
	public function _initialize(){
		parent::_initialize();//初始化模型
		$this->db = new \app\common\model\Article();
	}
    //首页
    public function index(){
    	$feild = $this->db->getAll(2);
    	$this->assign('feild',$feild);
    	return $this->fetch();
    }

    //文章添加
    public function store(){
    	if(request()->isPost()){
    		$res = $this->db->store(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');
    			exit;
    		}else{
    			$this->error($res['msg']);
    			exit;
    		}
    	}


    	//1.获取分类数据
    	$cateDate = (new Category())->getAll();
    	$this->assign('cateDate',$cateDate);
    	//2.获取标签数据
    	$tagDate = db('tag')->select();
    	//halt($tagDate);
    	$this->assign('tagDate',$tagDate);
    	return $this->fetch();
    }

    /**
     * 修改排序
     */
    public function changeSort(){
    	if(request()->isAjax()){
    		$res = $this->db->changeSort(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');
    			exit;
    		}else{
    			$this->error($res['msg']);
    			exit;
    		}
    	}
    }

    /**
     * 文章编辑
     */
    public function edit(){
    	if(request()->isPost()){
    		$res = $this->db->edit(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');
    			exit;
    		}else{
    			$this->error($res['msg']);
    			exit;
    		}
    	}
    	$arc_id = input('param.arc_id');
    	//1.获取分类数据
    	$cateDate = (new Category())->getAll();
    	$this->assign('cateDate',$cateDate);
    	//2.获取标签数据
    	$tagDate = db('tag')->select();
    	//halt($tagDate);
    	$this->assign('tagDate',$tagDate);
    	//3.获取旧数据
    	$oldData = db('article')->find($arc_id);
    	$this->assign('oldData',$oldData);
    	//获取当前文章所有标签id
    	$tag_ids = db('arc_tag')->find('tag_id');
    	//halt($tag_ids);
    	$this->assign('tag_ids',$tag_ids);
    	return $this->fetch();
    }


    //删除到回收站
    public function delToRecycle(){
    	$arc_id = input('param.arc_id');
    	//halt($arc_id);
    	//将该数据删除到回收站
    	if($this->db->save(['is_recycle'=>1],['arc_id'=>$arc_id])){
    		$this->success('操作成功','index');
    		exit;
    	}else{
    		$this->error('操作失败');
    		exit;
    	}
    	
    	//return $this->fetch();
    }

    //回收站管理
    public function recycle(){
    	$feild = $this->db->getAll(1);
    	$this->assign('feild',$feild);
    	return $this->fetch();
    }

    /**
     * 还原数据
     */
    public function outToRecycle(){
    	$arc_id = input('param.arc_id');
    	//halt($arc_id);
    	//将该数据删除到回收站
    	if($this->db->save(['is_recycle'=>2],['arc_id'=>$arc_id])){
    		$this->success('操作成功','index');
    		exit;
    	}else{
    		$this->error('操作失败');
    		exit;
    	}
    }

    /**
     * 彻底删除
     */
    public function del(){
    	$arc_id = input('get.arc_id');
    	$res = $this->db->del($arc_id);
    	if($res['valid']){
    		$this->success($res['msg'],'recycle');
    		exit;
    	}else{
    		$this->error($res['msg']);
    		exit;
    	}
    }
}
