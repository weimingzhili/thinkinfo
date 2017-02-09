<?php
namespace Admin\Controller;

use Think\Exception;

/**
 * 推荐位内容操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class PositionContentController extends CommonController {
        /**
         * 输出列表页
         */
        public function index() {
            // 获取推荐位
            $positions = D('Position')->getPosition(array('status'=>1));

            // 获取用户搜索的条件
            $pos_id = $_GET['pos_id'];
            $titleStr = $_GET['title'];
            if(isset($pos_id) && is_numeric($pos_id)) {
                $where['pos_id'] = intval($pos_id);
                $this->assign('pos_id',$where['pos_id']);
            }
            if(!empty($titleStr)) {
                $title = htmlspecialchars(trim($titleStr));
                $where['title'] = array('like','%'.$title.'%');
                $this->assign('title',$title);
            }

            // 获取分页数据
            $pageSize = 5;
            $where['status'] = array('neq',-1);
            $pageData = D('PositionContent')->positionContentPage($pageSize,$where);

            $this->assign(array(
                'positions' => $positions,
                'list' => $pageData['list'],
                'nav' => $pageData['nav'],
            ));
            $this->display();
        }

        /**
         * 列表排序
         * @return array
         */
        public function order() {
            $listArr = $_POST['listData'];
            if(!empty($listArr)) {
                $url = $_SERVER['HTTP_REFERER'];

                try {
                    $result = D('PositionContent')->listOrder($listArr);
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'排序失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }

        /**
         * 推荐位内容添加
         * @return array
         */
        public function add() {
            if(!empty($_POST)) {
                $positionContentModel = D('PositionContent');
                $checkRes = $positionContentModel->positionContentCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }
                try {
                    $addRes = $positionContentModel->positionContentAdd($_POST);
                    if($addRes) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'添加成功！'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'添加失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            } else {
                $positions = D('Position')->getPosition(array('status'=>1));
                $this->assign('positions',$positions);
                $this->display();
            }

        }

        /**
         * 推荐位内容编辑
         * @return array
         */
        public function edit() {
            if(!empty($_POST['posc_id'])) {
                $posc_id = $_POST['posc_id'];
                $poscModel = D('PositionContent');

                $checkRes = $poscModel->positionContentCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn($checkRes);
                }

                try {
                    $result = $poscModel->poscUpdate($posc_id,$_POST);
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'保存成功！为您跳转到列表首页'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'保存失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            } else {
                $posc_id = $_GET['id'];
                if(!empty($posc_id)) {
                    $posc = D('PositionContent')->getPositionContent($posc_id);
                    if(empty($posc)) {
                        $this->ajaxReturn(array('status'=>0,'message'=>'数据异常！'));
                    }

                    $this->assign('posc',$posc);
                }
                $positions = D('Position')->getPosition(array('status'=>1));
                $this->assign('positions',$positions);

                $this->display();
            }
        }

        /**
         * 更新推荐位内容
         * @return array
         */
        public function update() {
            if(!empty($_POST['posc_id'])) {
                $posc_id = $_POST['posc_id'];
                $status = $_POST['status'];
                $url = $_SERVER['HTTP_REFERER'];

                try {
                    $result = D('PositionContent')->poscUpdate($posc_id,$status);
                    if($result) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'操作成功！','url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'操作失败！'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }
    }