<?php

namespace Admin\Controller;

use Think\Exception;

/**
 * 菜单操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class MenuController extends CommonController {

        /**
         * 输出菜单列表页
         */
        public function index() {
            // 菜单分页
            $where['status'] = array('neq','-1');   // 默认的查询条件
            // 获取筛选条件
            if(!empty($_GET['type']) && in_array($_GET['type'],array(1,2))) {
                $type = intval($_GET['type']);
                $where['type']= $type;
                $this->assign('type',$_GET['type']);
            }
            $pageSize = 5;      // 默认的每页显示记录数

            // 获取分页
            $page = D('Menu')->menuPages($where,$pageSize);
            $this->assign(array(
                'show' => $page['show'],
                'list' => $page['list'],
            ));

            // 输出到模板
            $this->display();
        }

        /**
         * 菜单排序
         * @return array
         */
        public function listOrder() {
            if(!empty($_POST)) {
                $menuModel = D('Menu');
                $errors = array();
                $url = $_SERVER['HTTP_REFERER'];

                // 更新记录
                try {
                    foreach($_POST as $menu_id => $listorder) {
                        $result = $menuModel->listUpdate($menu_id,$listorder);
                        if($result === false) {
                            $errors[] = $menu_id;
                        }
                    }

                    if(empty($errors)) {
                        $this->ajaxReturn(array('status'=>1,'url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'排序失败'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>'排序失败'));
                }
            }
        }

        /**
         * 添加菜单
         * @return array
         */
        public function add() {
            // 判断用户是否提交
            if(!empty($_POST)) { // 当POST数据不为空时，认为用户执行的是菜单添加操作
                // 检查表单数据
                $checkRes = D('Menu')->checkMenu($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                // 添加菜单
                try {
                    $result = D('Menu')->menuAdd($_POST);
                    if($result == false) {
                        $this->ajaxReturn(array('status'=>0,'message'=>'菜单添加失败'));
                    }

                    $this->ajaxReturn(array('status'=>1));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }

            }

            // 输出菜单添加页面
            $this->display();
        }

        /**
         * 编辑菜单
         * @return array
         */
        public function edit() {
            if($_POST['id']) { // 当POST数据存在id时，认为用户执行的是菜单保存操作
                // 检查表单数据
                $checkRes = D('Menu')->checkMenu($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                // 更新菜单记录
                try {
                    $updateRes = D('Menu')->updateMenu($_POST['id'],$_POST);
                    if($updateRes === false) {
                        $this->ajaxReturn(array('status'=>0,'message'=>'菜单编辑失败'));
                    }

                    $this->ajaxReturn(array('status'=>1,'message'=>'菜单编辑成功，为您转到列表首页'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }

            } else { // 输出菜单添加页面
                $menu_id = $_GET['id'];
                $menu = D('Menu')->getMenu($menu_id);
                $this->assign('menu',$menu);
                $this->display();
            }

        }

        /**
         * 更新菜单状态
         * @return array
         */
        public function updateStatus() {
            if(!empty($_POST)) {
                // 获取数据
                $menu_id = $_POST['menu_id'];
                $menuData['status'] = $_POST['status'];
                $url = $_SERVER['HTTP_REFERER'];

                // 更新记录
                try{
                    $updateRes = D('Menu')->updateMenu($menu_id,$menuData);
                    if($updateRes === false) {
                        $this->ajaxReturn(array('status'=>0,'message'=>'操作失败'));
                    }

                    $this->ajaxReturn(array('status'=>1,'message'=>'操作成功','url'=>$url));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }
    }
