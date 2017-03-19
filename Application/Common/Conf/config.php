<?php
/**
 * 应用配置文件
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    return array(
        // URL设置
        'URL_MODEL' => 2,    // REWRITE模式

        // 数据库配置
        'DB_TYPE'   => 'mysql',            // 数据库类型
        'DB_HOST'   => '192.168.100.154',  // 服务器地址
        'DB_NAME'   => 'thinkinfo',        // 数据库名
        'DB_USER'   => 'thinkinfo',        // 用户名
        'DB_PWD'    => 'Rfvs69rdk*',       // 密码
        'DB_PORT'   => '3306',             // 端口

        //加密
        'MD5_PRE' => 'think_',    // 密码加密后缀

        // 其他
        'HTML_FILE_SUFFIX' => '.html',    // 静态页面后缀
    );
