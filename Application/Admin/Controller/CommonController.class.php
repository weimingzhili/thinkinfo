<?php
namespace Admin\Controller;

use Think\Controller;

/**
 * 后台公用类
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class CommonController extends Controller {

        public function __construct() {
            parent::__construct();    // 继承Controller的构造方法
            $this->_init();    // 调用初始化方法
        }

        /**
         * 初始化
         */
        private function _init() {
            // 判断用户是否登录
            $result = $this->isLogin();
            if(!$result) {
                $this->redirect('/Admin/Login/index');
            }

            // 获取导航菜单
            $this->getNavMenus();
        }

        /**
         * 获取登录用户信息
         * @return array
         */
        public function getLoginInfo() {
            return session('admin');
        }

        /**
         * 判断用户是否登录
         * @return boolean
         */
        public function isLogin() {
            $admin = $this->getLoginInfo();
            if($admin && is_array($admin) && $admin['username']) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * 获取导航菜单
         */
        public function getNavMenus() {
            $where = array('type'=>2,'status'=>1);
            $navMenus = D('Menu')->getMenu($where);

            if(session('admin.username') != 'wmzl') {
                foreach($navMenus as $key => $value) {
                    if($value['c'] == 'Admin') {
                        unset($navMenus[$key]);
                    }
                }
            }
            $this->assign('navMenus',$navMenus);
        }

    }
