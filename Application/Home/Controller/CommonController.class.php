<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 前台公用类
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class CommonController extends Controller {
        public function __construct() {
            parent::__construct();
            header('Content-type:text/html; charset=utf-8');
        }

        /**
         * 输出错误页面
         * @param string $errInfo
         */
        public function error($errInfo='') {
            $message = $errInfo ? $errInfo : '系统发生错误';
            $this->assign('message',$message);
            $this->display("Index/error");
        }
    }
