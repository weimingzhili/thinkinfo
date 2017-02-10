<?php

namespace Admin\Controller;

use Think\Exception;

/**
 * 管理员管理
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class AdminController extends CommonController {
        /**
         * 输出列表页
         */
        public function index() {
            $pageSize = 5;
            $where['status'] = array('neq',-1);
            $pageData = D('Admin')->adminPage($where,$pageSize);
            $this->assign(array(
                'list' => $pageData['list'],
                'nav'  => $pageData['nav'],
            ));
            $this->display();
        }

        /**
         * 用户添加
         * @return array
         */
        public function add() {
            if(!empty($_POST)) { // 当POST数据不为空时，认为用户执行的是添加操作
                // 检查数据
                $adminModel = D('Admin');
                $checkRes = $adminModel->adminCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                // 添加用户
                try {
                    $result = $adminModel->adminAdd($_POST);
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'添加成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'添加失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            } else { // 输出菜单添加页面
                $this->display();
            }
        }

        /**
         * 更新用户
         * @return array
         */
        public function update() {
            if(!empty($_POST)) {
                // 获取数据
                $id = $_POST['id'];
                $status = $_POST['status'];
                $url = $_SERVER['HTTP_REFERER'];

                // 更新记录
                try {
                    $result = D('Admin')->adminUpdate($id,$status);
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'操作成功！','url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'操作失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }

        /**
         * 个人中心
         * @return array
         */
        public function personal() {
            if(!empty($_POST['admin_id'])) { // 当POST数据中存在admin_id，认为用户是在更新资料
                $username = session('admin.username');

                // 更新用户记录
                try {
                    $result = D('Admin')->adminUpdate($username,$_POST,array('realname','email'));
                    if($result !== false) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'保存成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'保存失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>1,'message'=>$e->getMessage()));
                }
            } else { // 展示用户资料
                $adminInfo = $this->getLoginInfo();
                $admin_id = $adminInfo['admin_id'];
                $admin = D('Admin')->getAdmin($admin_id);
                $this->assign('admin',$admin);
                $this->display();
            }
        }
    }