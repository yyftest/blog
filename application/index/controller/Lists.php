<?php

namespace app\index\controller;


class Lists extends Common
{
	//首页
    public function index(){
    	$headConf = ['title'=>'博客--列表页'];
    	$this->assign('headConf',$headConf);
    	//获取左侧第一部分的数据
    	$cate_id = input('param.cate_id');
    	$tag_id = input('param.tag_id');
    	//按分类获取数据
    	if($cate_id){
    		//获取当前子集分类id
    		$cids = (new \app\common\model\Category())->getSon(db('cate')->select(),$cate_id);
    		$cids[] = $cate_id;//把自己追加进去
    		$headData = [
    			'title'=>'分类',
    			'name'=>db('cate')->where('cate_id',$cate_id)->value('cate_name'),
    			'total'=>db('article')->whereIn('cate_id',$cids)->count(),
    		];
    		//获取文章数据
    		$articleData = db('article')->alias('a')
    		->join('blog_cate c','a.cate_id=c.cate_id')->where('is_recycle',2)->whereIn('a.cate_id',$cids)->select();	
    	}

    	//按标签获取数据
    	if($tag_id){
    		$headData = [
    			'title'=>'标签',
    			'name'=>db('tag')
    			->where('tag_id',$tag_id)->value('tag_name'),
    			'total'=>db('arc_tag')->where('tag_id',$tag_id)
    			->count(),
    		];
    	//获取文章数据
    	$articleData = db('article')->alias('a')
    	->join('blog_arc_tag at','a.arc_id=at.arc_id')
    	->join('cate c','a.cate_id=c.cate_id')
    	->where('is_recycle',2)
    	->where('at.tag_id',$tag_id)->select();
    	//halt($articleData);
    	}
    	foreach($articleData as $k=>$v){
    		$articleData[$k]['tags'] = db('arc_tag')->alias('at')
    		->join('blog_tag t','at.tag_id=t.tag_id')
    		->where('at.arc_id',$v['arc_id'])
    		->field('t.tag_id,t.tag_name')->select();
    	}
    	//dump($articleData);
    	$this->assign('headData',$headData);
    	$this->assign('articleData',$articleData);

    	return $this->fetch();
    }




}
