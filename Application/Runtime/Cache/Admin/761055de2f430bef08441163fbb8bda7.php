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

  <script src="/Public/js/kindeditor/kindeditor-all.js"></script>
  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/Admin/Article/index">文章管理</a>
            </li>
            <li class="active">
              <i class="fa fa-edit"></i> 文章编辑
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-lg-6">

          <form class="form-horizontal" id="article-edit-form">
            <div class="form-group">
              <label for="title" class="col-sm-2 control-label">标题:</label>
              <div class="col-sm-5">
                <input type="text" name="title" class="form-control" id="title" placeholder="请填写标题" value="<?php echo ($article['title']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="subtitle" class="col-sm-2 control-label">短标题:</label>
              <div class="col-sm-5">
                <input type="text" name="small_title" class="form-control" id="subtitle" placeholder="请填写短标题" value="<?php echo ($article['small_title']); ?>">
              </div>
            </div>

            <!-- 缩略图上传 -->
            <div class="form-group">
              <label for="thumb-upload" class="col-sm-2 control-label">缩略图：</label>
              <div class="col-sm-5">
                说明：只能上传一张缩略图，格式必须是gif、jpg、jpeg以及png类型，且大小不能大于1M。
                <input type="file" id="thumb-upload" multiple="multiple">
                <img style="<?php echo (showThumb($article['thumb'])); ?>" id="thumb-Img" src="<?php echo ($article['thumb']); ?>" alt="缩略图">
                <input type="hidden" id="thumb" name="thumb" value="<?php echo ($article['thumb']); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="cat" class="col-sm-2 control-label">所属栏目:</label>
              <div class="col-sm-5">
                <select class="form-control" name="cat_id" id="cat">
                  <option value="null">请选择栏目</option>
                  <?php if(is_array($cat)): $i = 0; $__LIST__ = $cat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["menu_id"]); ?>" <?php if(($article['cat_id']) == $vo['menu_id']): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
              </div>
            </div>
            <!-- 来源 -->
            <div class="form-group">
              <label for="source" class="col-sm-2 control-label">来源:</label>
              <div class="col-sm-5">
                <input type="text" id="source" name="source" class="form-control" placeholder="请输入来源" value="<?php echo ($article['source']); ?>">
              </div>
            </div>

            <!-- KindEditor文本编辑框 -->
            <div class="form-group">
              <label for="KindEditor" class="col-sm-2 control-label">内容：</label>
              <div class="col-sm-5">
                <textarea class="input js-editor" name="content" id="KindEditor" cols="30" rows="20"><?php echo ($content); ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">描述:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="description" id="description" placeholder="描述" value="<?php echo ($article['description']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="keyword" class="col-sm-2 control-label">关键字:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="keywords" id="keyword" placeholder="请填写关键词" value="<?php echo ($article['keywords']); ?>">
              </div>
            </div>

            <input type="hidden" name="article_id" value="<?php echo ($article['article_id']); ?>">

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" id="article-edit-submit">提交</button>
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

<script src="/Public/js/admin/common.js"></script>
<script src="/Public/js/admin/menu.js"></script>
<script src="/Public/js/admin/article.js"></script>
<script src="/Public/js/admin/position.js"></script>
<script src="/Public/js/admin/positionContent.js"></script>
<script src="/Public/js/admin/basic.js"></script>
<script src="/Public/js/admin/admin.js"></script>
</body>
</html>