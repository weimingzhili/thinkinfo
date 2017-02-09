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
            $this->assign('list',$pageData['list']);
            $this->assign('nav',$pageData['nav']);
            $this->display();
        }

        /**
         * 用户添加
         * @return array
         */
        public function add() {
            if(!empty($_POST)) {
                $adminModel = D('Admin');
                $checkRes = $adminModel->adminCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                try {
                    $result = $adminModel->adminAdd($_POST);
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'添加成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'添加失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            } else {
                $this->display();
            }
        }

        /**
         * 更新用户
         * @return array
         */
        public function update() {
            if(!empty($_POST)) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $url = $_SERVER['HTTP_REFERER'];

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
            if(!empty($_POST['admin_id'])) {
                $username = session('admin.username');

                try {
                    $result = D('Admin')->adminUpdate($username,$_POST,array('realname','email'));
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'保存成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'保存失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>1,'message'=>$e->getMessage()));
                }
            } else {
                $adminInfo = $this->getLoginInfo();
                $admin_id = $adminInfo['admin_id'];
                $admin = D('Admin')->getAdmin($admin_id);
                $this->assign('admin',$admin);
                $this->display();
            }
        }
    }