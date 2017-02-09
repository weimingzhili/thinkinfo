<?php
namespace Admin\Controller;

/**
 * 后台首页
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class IndexController extends CommonController {
        /**
         * 输出后台首页
         */
        public function index(){
            //获取平台整理指标
            $articleTotal = D('Article')->getTotal();
            $menuTotal = D('Menu')->getTotal();
            $adminTotal = D('Admin')->getTotal();
            $positionTotal = D('Position')->getTotal();
            $this->assign([
                'articleTotal'  => $articleTotal,
                'menuTotal'     => $menuTotal,
                'adminTotal'    => $adminTotal,
                'positionTotal' => $positionTotal,
            ]);
            $this->display();
        }
    }