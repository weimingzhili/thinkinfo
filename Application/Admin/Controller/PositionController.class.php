<?php

namespace Admin\Controller;

use Think\Exception;

/**
 * 推荐位操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class PositionController extends CommonController {
        // 输出列表页
        public function index() {
            // 获取分页数据
            $where['status'] = array('neq',-1);
            $positions = D('Position')->positionPage($where);
            $this->assign(array(
                'list' => $positions['list'],
                'nav'  => $positions['nav'],
            ));
            $this->display();
        }

        /**
         * 添加推荐位
         * @return  array
         */
        public function add() {
            if(!empty($_POST)) { // 当POST数据不为空，认为用户执行的是添加操作
                // 检查数据
                $positionModel = D('Position');
                $checkRes = $positionModel->positionCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                // 写入数据库
                try {
                    $addRes = $positionModel->positionAdd($_POST);
                    if($addRes) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'添加成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'添加失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            } else { // 输出添加页面
                $this->display();
            }
        }

        /**
         * 编辑推荐位
         * @return array
         */
        public function edit() {
            $id = $_GET['id'];

            if(isset($id)) {
                $position = D('Position')->getPosition($id);
                $this->assign('position',$position);
            }

            $this->display();
        }

        /**
         * 保存推荐位
         * @return array
         */
        public function save() {
            $id = $_POST['pos_id'];
            if(isset($id)) {
                // 检查数据
                $positionModel = D('position');
                $checkRes = $positionModel->positionCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                // 更新记录
                try {
                    $saveRes = $positionModel->positionUpdate($id,$_POST);
                    if($saveRes) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'保存成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'保存失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }

        /**
         * 更新推荐位
         * @return array
         */
        public function update() {
            $id = $_POST['pos_id'];
            if(isset($id)) {
                $url = $_SERVER['HTTP_REFERER'];

                // 更新记录
                try {
                    $updateRes = D('Position')->positionUpdate($id,$_POST['status']);
                    if($updateRes) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'操作成功！','url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'操作失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }
    }
