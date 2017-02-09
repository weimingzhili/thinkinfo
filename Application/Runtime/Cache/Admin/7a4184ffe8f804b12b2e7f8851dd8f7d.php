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
              <i class="fa fa-dashboard"></i>  <a href="/Admin/Article/index">文章管理</a>
            </li>
            <li class="active">
              <i class="fa fa-table"></i>文章列表
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->
      <div >
        <button  id="article-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加</button>
      </div>

      <br>

      <div class="row">
        <form action="/Admin/Article/index" method="get">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon">栏目</span>
              <select class="form-control" name="catId" title="catSelect">
                <option value="0" >请选择栏目</option>
                <?php if(is_array($homeMenus)): $i = 0; $__LIST__ = $homeMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["menu_id"]); ?>" <?php if(($vo["menu_id"]) == $cat_id): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
          </div>
          <input type="hidden" name="c" value="content"/>
          <input type="hidden" name="a" value="index"/>
          <div class="col-md-3">
            <div class="input-group">
              <input class="form-control" name="title" type="text" value="<?php echo ($title); ?>" placeholder="文章标题" />
                <span class="input-group-btn">
                  <button id="sub_data" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
          </div>
        </form>
      </div>
      <br>
      <div class="row">
        <div class="col-lg-6">
          <div class="table-responsive">
            <form id="article-list-form">
              <table class="table table-bordered table-hover article-table">
                <tr>
                  <th><input type="checkbox" title="选择框"></th>
                  <th>排序</th>
                  <th>id</th>
                  <th>标题</th>
                  <th>栏目</th>
                  <th>来源</th>
                  <th>封面图</th>
                  <th>创建时间</th>
                  <th>更新时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                  <?php if(is_array($pageList)): $i = 0; $__LIST__ = $pageList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                      <td><input type="checkbox" name="push-article" value="<?php echo ($vo["article_id"]); ?>" title="选择框"></td>
                      <td><input size="4" type="text" name="<?php echo ($vo["article_id"]); ?>" value="<?php echo ($vo["list_id"]); ?>" title="排序id输入框"></td>
                      <td><?php echo ($vo["article_id"]); ?></td>
                      <td><?php echo ($vo["title"]); ?></td>
                      <td><?php echo (getCatName($homeMenus,$vo["cat_id"])); ?></td>
                      <td><?php echo ($vo["source"]); ?></td>
                      <td><?php echo (checkThumb($vo["thumb"])); ?></td>
                      <td><?php echo (checkTime($vo["create_time"])); ?></td>
                      <td><?php echo (checkTime($vo["update_time"])); ?></td>
                      <td>
                        <?php echo (getStatus($vo["status"])); ?>
                      </td>
                      <td>
                        <!-- 编辑按钮 -->
                        <a href="<?php echo U('Admin/Article/edit?id='.$vo['article_id']);?>" title="编辑" id="article-edit" attr-id=""><span class="glyphicon glyphicon-edit" ></span></a>
                        <!-- 开启/关闭按钮 -->
                        <a href="javascript:void(0)" title="开启/关闭" id="article-up-down" attr-id="<?php echo ($vo['article_id']); ?>" attr-status="<?php echo ($vo["status"]); ?>"><span class="glyphicon glyphicon-off"></span></a>
                        <!-- 删除按钮 -->
                        <a href="javascript:void(0)" id="article-delete" attr-id="<?php echo ($vo['article_id']); ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
                        <!-- 预览入口 -->
                        <a href="<?php echo U('Home/Detail/view?id='.$vo['article_id']);?>" title="预览"><span class="glyphicon glyphicon-eye-open"></span></a>
                      </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </table>
            </form>
          </div>
        </div>
      </div>

      <!-- /.row -->
      </div>

    <!-- 排序按钮 -->
    <div class="row">
      <div class="col-lg-6">
        <div class="col-md-3">
          <button type="button" id="article-list" class="btn btn-primary"><span class="glyphicon glyphicon-sort"></span> 排序</button>
        </div>
      </div>
    </div>

    <br>

    <!-- 推荐位下拉列表与推送按钮 -->
    <div class="row">
      <div class="col-lg-6">
        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-addon">推荐位</span>
            <!-- 推荐位下拉列表 -->
            <select class="form-control" id="pos_id" title="推荐位下拉列表">
              <option value="null" >请选择推荐位</option>
              <?php if(is_array($positions)): $i = 0; $__LIST__ = $positions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$position): $mod = ($i % 2 );++$i;?><option value="<?php echo ($position["pos_id"]); ?>"><?php echo ($position["pos_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </div>
        </div>
        <!-- 推送按钮 -->
        <button type="button" id="article-push" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span> 推送</button>
        </div>
      </div>

    <br>

    <!-- 分页导航 -->
    <div class="row">
      <nav class="page">
        <?php echo ($pageNav); ?>
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
<script src="/Public/js/admin/position.js"></script><!-- 推荐位js文件 -->
<script src="/Public/js/admin/positionContent.js"></script><!-- 推荐位内容js文件 -->
<script src="/Public/js/admin/basic.js"></script><!-- 基本配置js文件 -->
<script src="/Public/js/admin/admin.js"></script><!-- 用户管理 -->
</body>

</html>