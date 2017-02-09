<?php
/**
 * 应用入口文件
 * @author WeiZeng <weimingzhili@gmail.com>
 */

    // 开启调试模式
    define('APP_DEBUG',true);

    // 关闭目录安全文件生成
    define('BUILD_DIR_SECURE',false);

    // 绑定Admin模块到入口文件
    // define('BIND_MODULE','Admin');

    // 定义静态文件目录
    define('HTML_PATH','./');

    // 定义应用目录
    define('APP_PATH','./Application/');

    // 引入ThinkPHP入口文件
    require './ThinkPHP/ThinkPHP.php';
