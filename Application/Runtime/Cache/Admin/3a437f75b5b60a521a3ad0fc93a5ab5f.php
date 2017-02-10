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

    <div class="container-fluid" >

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/Admin/Position/index">推荐位管理</a>
            </li>
            <li class="active">
              <i class="fa fa-table"></i>推荐位列表
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->

      <div >
        <!-- 推荐位添加按钮 -->
        <button  id="position-list-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span> 添加</button>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <h3></h3>
          <div class="table-responsive">
            <!-- 推荐位列表表单 -->
            <form id="position-list-form">
              <!-- 推荐位列表 -->
              <table class="table table-bordered table-hover position-list-table">
                <tr>
                  <th>id</th>
                  <th>推荐位名称</th>
                  <th>描述</th>
                  <th>创建时间</th>
                  <th>更新时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$position): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($position['pos_id']); ?></td><!-- 推荐位id -->
                    <td><?php echo ($position['pos_name']); ?></td><!-- 推荐位名称 -->
                    <td><?php echo ($position['description']); ?></td><!-- 推荐位描述 -->
                    <td><?php echo (checkTime($position['create_time'])); ?></td><!-- 创建时间 -->
                    <td><?php echo (checkTime($position['update_time'])); ?></td><!-- 更新时间 -->
                    <td><?php echo (getStatus($position['status'])); ?></td><!-- 状态 -->
                    <!-- 操作 -->
                    <td>
                      <!-- 编辑推荐位 -->
                      <a href="<?php echo U('/Admin/Position/edit?id='.$position['pos_id']);?>" title="编辑推荐位"><span class="glyphicon glyphicon-edit" id="position-edit"></span></a>
                      <!-- 开启/关闭推荐位 -->
                      <a href="javascript:void(0)" id="position-on-off" title="开启/关闭推荐位" attr-status="<?php echo ($position['status']); ?>" attr-id="<?php echo ($position['pos_id']); ?>"><span class="glyphicon glyphicon-off"></span></a>
                      <!-- 删除推荐位 -->
                      <a href="javascript:void(0)" id="position-delete"  attr-id="<?php echo ($position['pos_id']); ?>" title="删除推荐位"><span class="glyphicon glyphicon-remove-circle"></span></a>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </table>
            </form>
          </div>
        </div>

      </div>
      <!-- /.row -->
      <!-- 分页导航 -->
      <nav class="page">
        <?php echo ($nav); ?>
      </nav>

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<script src="/Public/js/admin/common.js"></script>
<script src="/Public/js/admin/menu.js"></script>
<script src="/Public/js/admin/article.js"></script>
<script src="/Public/js/admin/position.js"></script>
<script src="/Public/js/admin/positionContent.js"></script>
<script src="/Public/js/admin/basic.js"></script>
<script src="/Public/js/admin/admin.js"></script>
</body>
</html>