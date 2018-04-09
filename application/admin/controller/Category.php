<?php 
namespace app\admin\controller;


/**
 * 栏目管理
 */
class Category extends Common{
	protected $db;
	protected function _initialize(){
		parent::_initialize();//初始化模型
		$this->db = new \app\common\model\Category();
	}


	//首页
	public function index(){
		//获取栏目数据
		//$field = db('cate')->select();
		$field = $this->db->getAll();
		//halt($field);
		$this->assign('field',$field);
		return $this->fetch();
	}

	//添加
	public function store(){
		if(request()->isPost()){
			//halt(input('post.'));
			$res = $this->db->store(input('post.'));
			if($res['valid']){
				//操作成功
				$this->success($res['msg'],'index');
				exit;
			}else{
				//操作失败
				$this->error($res['msg']);
				exit;
			}
		}
		return $this->fetch();
	}

	//添加子类
	public function addson(){
		if(request()->isPost()){
			// 调用当前模型对应的Category验证器类进行数据验证
			$res = $this->db->store(input('post.'));
			if($res['valid']){
				//操作成功
				$this->success($res['msg'],'index');
				exit;
			}else{
				//操作失败
				$this->error($res['msg']);
				exit;
			}
		}

		//获取地址中的cate_id
		$cate_id = input('param.cate_id');
		//halt($cate_id);
		$data = $this->db->where('cate_id',$cate_id)->find();
		$this->assign('data',$data);
		return $this->fetch();
	}

	//栏目编辑
	public function edit(){
		if(request()->isPost()){
			//halt($_POST);
			$res = $this->db->edit(input('post.'));
			if($res['valid']){
				//执行成功
				$this->success($res['msg'],'index');
				exit;
			}else{
				//执行失败
				$this->error($res['msg']);
				exit;
			}
		}


		//获取地址中的cate_id
		$cate_id = input('param.cate_id');
		//halt($cate_id);
		$oldData = $this->db->find($cate_id);
		//halt($oldData);
		$this->assign('oldData',$oldData);

		//处理所属分类【不能包含自己和自己的子集数据】
		$cateData = $this->db->getCateData($cate_id);
		//halt($cateData);
		$this->assign('cateData',$cateData);
		return $this->fetch();
	}

	//栏目删除
	public function del(){
		$cate_id = input('get.cate_id');
		$res = $this->db->del($cate_id);
		if($res['valid']){
			$this->success($res['msg'],'index');
			exit;
		}else{
			$this->error($res['msg']);
			exit;
		}
	}



}




