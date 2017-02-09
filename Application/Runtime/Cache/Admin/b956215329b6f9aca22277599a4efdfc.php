<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
    <!--<script type="text/javascript" src="/Public/js/party/jquery.uploadify.js"></script>-->
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
                        <i class="fa fa-dashboard"></i>  <a href="/admin.php?c=menu">菜单管理</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i><?php echo ($nav); ?>
                    </li>
                </ol>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <!-- 筛选表单，其中action属性被定义为到Menu控制器中的index方法，method设为get -->
            <form action="/Admin/Menu/index" method="get">
                <div class="input-group">
                    <span class="input-group-addon">类型</span>
                    <!-- 提供筛选按钮的下拉列表，其中select标签没有闭合，但一旦闭合后，我注意到页面样式会出问题，因此保持原样 -->
                    <select class="form-control" name="type">
                        <option value="0" >请选择类型</option>
                        <option value="1" <?php if(($type) == "1"): ?>selected<?php endif; ?> >前端导航</option>
                        <option value="2" <?php if(($type) == "2"): ?>selected<?php endif; ?> >后台菜单</option>
                    </lect>
                </div>

                <input type="hidden">
                <input type="hidden">
                <span class="input-group-btn">
                  <button id="sub_data" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </form>
        </div>

        <div>
          <button  id="button-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加</button>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h3></h3>
                <div class="table-responsive">
                    <form id="singcms-listorder">
                    <table class="table table-bordered table-hover singcms-table">
                        <thead>
                        <tr>
                            <th width="14">排序</th>
                            <th>id</th>
                            <th>菜单名</th>
                            <th>模块名</th>
                            <th>类型</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><tr>
                                <!-- 排序id输入框 -->
                                <td><input size="4" type="text" name="<?php echo ($menu['menu_id']); ?>" value="<?php echo ($menu['list_id']); ?>"/></td>
                                <td><?php echo ($menu['menu_id']); ?></td>
                                <td><?php echo ($menu['name']); ?></td>
                                <td><?php echo ($menu['m']); ?></td>
                                <td><?php echo (getMenuType($menu['type'])); ?></td>
                                <td><?php echo (getStatus($menu['status'])); ?></td>
                                <td>
                                    <!-- 编辑按钮 -->
                                    <a href="<?php echo U('Admin/Menu/edit?id='.$menu['menu_id']);?>" title="编辑菜单"><span class="glyphicon glyphicon-edit" id="singcms-edit"></span></a>
                                    <!-- 关闭按钮 -->
                                    <a href="javascript:void(0)" title="关闭菜单" attr-id="<?php echo ($menu['menu_id']); ?>" id="menu-close" ><span class="glyphicon glyphicon-off"></span></a>
                                    <!-- 开启按钮 -->
                                    <a href="javascript:void(0)" title="开启菜单" attr-id="<?php echo ($menu['menu_id']); ?>" id="menu-up"><span class="glyphicon glyphicon-ok-circle"></span></a>
                                    <!-- 删除按钮 -->
                                    <a href="javascript:void(0)" attr-id="<?php echo ($menu['menu_id']); ?>" id="singcms-delete" title="删除菜单"><span class="glyphicon glyphicon-remove-circle" ></span></a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                        </tbody>
                    </table>
                        <!-- 排序按钮 -->
                        <button type="button" id="menu-list" class="btn btn-primary"><span class="glyphicon glyphicon-sort"></span> 排序</button>
                    </form>
                    <!-- 分页导航 -->
                    <nav class="page">
                      <?php echo ($show); ?>
                    </nav>
                    
                </div>
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
<script src="/Public/js/admin/position.js"></script><!-- 推荐位js文件 -->
<script src="/Public/js/admin/positionContent.js"></script><!-- 推荐位内容js文件 -->
<script src="/Public/js/admin/basic.js"></script><!-- 基本配置js文件 -->
<script src="/Public/js/admin/admin.js"></script><!-- 用户管理 -->
</body>

</html>