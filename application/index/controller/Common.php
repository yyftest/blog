<?php

namespace app\index\controller;
use think\Controller;
use think\Request;

class Common extends Controller
{
    public function __construct(Request $request = null){
    	parent::__construct($request);
    	//读取配置项
    	$webset = $this->loadWebSet();
    	$this->assign('_webset',$webset);
        //获取顶级栏目数据
        $cateData = $this->loadCateData();
        $this->assign('_cateData',$cateData);
        //获取全部栏目数据
        $allCateData = $this->loadAllCateData();
        $this->assign('_allCateData',$allCateData);
        //获取标签数据
        $tagData = $this->loadTagData();
        $this->assign('_tagData',$tagData);
        //获取最新文章
        $arcData = $this->loadArcData();
        $this->assign('_arcData',$arcData);
        //获取友链
        $linkData = $this->loadLinkData();
        $this->assign('_linkData',$linkData);
    	
    }

    /**
     * 获取顶级分类数据
     */
    private function loadCateData(){
        return db('cate')->where('cate_pid',0)->order('cate_sort asc')->limit(5)->select();
    }

    /**
     * 读取全部栏目数据
     */
    private function loadAllCateData(){
        return db('cate')->order('cate_sort asc')->select();
    }

    /**
     * 读取标签数据
     */
    private function loadTagData(){
        return db('tag')->select();
    }

    /**
     * 读取最新文章数据
     */
    private function loadArcData(){
        return db('article')->order('sendtime desc')->field('arc_id,arc_title,sendtime')->limit(3)->select();
    }

    /**
     * 获取友链数据
     */
    private function loadLinkData(){
        return db('link')->order('link_sort desc')->limit(3)->select();
    }

    /**
     * 读取配置项
     */
    private function loadWebSet(){
    	//return db('webset')->select();
    	return db('webset')->column('webset_value','webset_name');
    }




}
