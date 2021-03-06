<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>think资讯管理平台</title>
  <link rel="icon" href="/Public/images/think.ico" type="image/x-icon">
  <link rel="icon" href="/Public/images/think.ico" type="image/x-icon">
  <!-- Bootstrap Core CSS -->
  <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="/Public/css/sb-admin.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="/Public/css/plugins/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="/Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/Public/css/sing/common.css" />
  <link rel="stylesheet" href="/Public/css/party/bootstrap-switch.css" />
  <!--<link rel="stylesheet" type="text/css" href="/Public/css/party/uploadify.css">-->
  <link rel="stylesheet" href="/Public/plugins/uploadify/uploadify.css">
  <link rel="stylesheet" href="/Public/css/admin/page.css">
  <!-- jQuery -->
  <script src="/Public/js/jquery.js"></script>
  <script src="/Public/js/bootstrap.min.js"></script>
  <script src="/Public/js/dialog/layer.js"></script>
  <script src="/Public/js/dialog.js"></script>
  <script src="/Public/plugins/uploadify/jquery.uploadify.min.js"></script>
  <script src="/Public/js/admin/imageUpload.js"></script>
  <!-- 引入KindEditor的中文语言文件和js文件 -->
  <script src="/Public/plugins/kindeditor/kindeditor-all-min.js"></script>
  <script src="/Public/plugins/kindeditor/lang/zh_CN.js"></script>
</head>

<body>

<div id="wrapper">

  <!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    
    <a class="navbar-brand" >think资讯管理平台</a>
  </div>
  <!-- Top Menu Items -->
  <ul class="nav navbar-right top-nav">
    
    
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo session('admin.username') ?> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="<?php echo U('/Admin/Admin/personal');?>"><i class="fa fa-fw fa-user"></i> 个人中心</a>
        </li>
       
        <li class="divider"></li>
        <li>
          <a href="/Admin/Login/logout"><i class="fa fa-fw fa-power-off"></i> 注销</a>
        </li>
      </ul>
    </li>
  </ul>
  <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav nav_list">
      <li <?php echo showStyle('Index');?>>
        <a href="<?php echo U('/Admin/Index/index');?>"><i class="fa fa-fw fa-dashboard"></i> 首页</a>
      </li>
      <?php if(is_array($navMenus)): $i = 0; $__LIST__ = $navMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php echo (showStyle($vo['c'])); ?>>
              <a href="<?php echo U('/Admin/'.$vo['c'].'/index');?>"><i class="fa fa-fw fa-bar-chart-o"></i><?php echo ($vo['name']); ?></a>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
  <!-- /.navbar-collapse -->
</nav>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/admin.php?c=menu">菜单管理</a>
            </li>
            <li class="active">
              <i class="fa fa-edit"></i> 编辑
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-lg-6">

          <form class="form-horizontal" id="singcms-form">
            <div class="form-group">
              <label for="inputname" class="col-sm-2 control-label">菜单名:</label>
              <div class="col-sm-5">
                <input type="text" name="name" class="form-control" id="inputname" placeholder="请填写菜单名" value="<?php echo ($menu['name']); ?>">
              </div>
            </div>
            <!--<div class="form-group">
                <label for="inputname" class="col-sm-2 control-label">父类菜单ID:</label>
                <div class="col-sm-5">
                    <select class="form-control" name="parentid">
                        <option value="0">一级菜单</option>
                        <?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$parent): $mod = ($i % 2 );++$i;?><option value="<?php echo ($parent["menu_id"]); ?>"><?php echo ($parent["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>-->
            <div class="form-group">
              <label class="col-sm-2 control-label">菜单类型:</label>
              <div class="col-sm-5">
                <input type="radio" name="type" value="1" title="前端栏目" <?php if(($menu['type']) == "1"): ?>checked<?php endif; ?>> 前端栏目
                <input type="radio" name="type" value="2" title="后台菜单" <?php if(($menu['type']) == "2"): ?>checked<?php endif; ?>> 后台菜单
              </div>

            </div>
            <div class="form-group">
              <label for="m" class="col-sm-2 control-label">模块名:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="m" id="m" placeholder="模块名如admin" value="<?php echo ($menu['m']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="c" class="col-sm-2 control-label">控制器:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="c" id="c" placeholder="控制器如index" value="<?php echo ($menu['c']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="a" class="col-sm-2 control-label">方法:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="f" id="a" placeholder="方法名如index" value="<?php echo ($menu['f']); ?>">
              </div>
            </div>

            <input type="hidden" name="id" value="<?php echo ($menu['menu_id']); ?>">

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" id="menu-edit">编辑</button>
              </div>
            </div>
          </form>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!-- Morris Charts JavaScript -->
<script src="/Public/js/admin/common.js"></script>
<script src="/Public/js/admin/menu.js"></script>
<script src="/Public/js/admin/article.js"></script>
<script src="/Public/js/admin/position.js"></script>
<script src="/Public/js/admin/positionContent.js"></script>
<script src="/Public/js/admin/basic.js"></script>
<script src="/Public/js/admin/admin.js"></script>
</body>
</html>