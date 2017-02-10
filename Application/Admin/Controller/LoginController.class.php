<?php

namespace Admin\Controller;

use Think\Controller;

use Think\Exception;

/**
 * 后台登录
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class LoginController extends Controller {

        /**
         * 继承父类的构造方法初始化
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * 输出登录页面
         */
        public function index() {
            //判断用户是否已经登录
            if(session('admin')) {
                $this->redirect('/Admin/Index/index');    // 已经登录跳转到后台首页
            } else {
                $this->display();    // 否则输出登录页面
            }
        }

        /**
         * 登录处理
         * @return string 登录验证结果
         */
        public function check() {
            // 获取表单数据
            $username = $_POST['username'];
            $password = $_POST['password'];

            // 对表单数据进行检查
            if(!trim($username)) {
                $this->ajaxReturn(array('status'=>0,'message'=>'用户名不能为空'));
            }
            if(!trim($password)) {
                $this->ajaxReturn(array('status'=>0,'message'=>'密码不能为空'));
            }

            // 验证登录
            $result = D('Admin')->getAdmin($username);      //获取用户记录

            if(!$result) {      // 判断用户记录是否存在
                $this->ajaxReturn(array('status'=>0,'message'=>'该用户不存在'));
            }
            if($result['status'] == 0) {    // 判断账户是否已经关闭
                $this->ajaxReturn(array('status'=>0,'message'=>'该账户已关闭'));
            }
            if($result['password'] != getMd5Password($password)) {      // 判断密码是否正确
                $this->ajaxReturn(array('status'=>0,'message'=>'密码错误'));
            }
            if($result['password'] == getMd5Password($password)) {
                $data['lastloginip'] = $_SERVER['HTTP_CLIENT_IP']
                                     ? $_SERVER['HTTP_CLIENT_IP']
                                     : $_SERVER['REMOTE_ADDR'];
                $data['lastlogintime'] = time();

                // 更新用户登录记录
                try {
                    $updateRes = D('Admin')->adminUpdate($username,$data);
                    if($updateRes) {
                        session('admin',$result);       // 将用户记录写入session
                        $this->ajaxReturn(array('status'=>1,'message'=>'登录成功！'));
                    }
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }

                $this->ajaxReturn(array('status'=>0,'message'=>'系统发生错误！'));
            }

            // 在以上条件都不满足的情况下提示登录失败
            $this->ajaxReturn(array('status'=>0,'message'=>'登录失败'));
        }

        /**
         * 用户退出
         */
        public function logout() {
            // 将Session数据清空
            session('admin', null);
            $this->redirect('/Admin/Login/index');
        }
    }