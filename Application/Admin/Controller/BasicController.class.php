<?php
namespace Admin\Controller;

/**
 * 基本配置
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class BasicController extends CommonController {
        /**
         * 输出页面
         */
        public function index() {
            $config = D('Basic')->getConfig();
            $this->assign('config',$config);
            $this->display();
        }

        /**
         * 保存配置
         * @return array
         */
        public function save() {
            if(!empty($_POST)) {
                $basicModel = D('Basic');
                $checkRes = $basicModel->configCheck($_POST);
                if($checkRes) {
                    $this->ajaxReturn(array('status'=>0,'message'=>'数据异常！'));
                }

                $result = $basicModel->configSave($_POST);
                if($result) {
                    $this->ajaxReturn(array('status'=>0,'message'=>'配置失败！'));
                }

                $this->ajaxReturn(array('status'=>1,'message'=>"配置成功！"));

            }
        }

        /**
         * 输出缓存配置页面
         */
        public function cache() {
            $user = getUsername();
            $this->assign('user',$user);
            $this->display();
        }
    }