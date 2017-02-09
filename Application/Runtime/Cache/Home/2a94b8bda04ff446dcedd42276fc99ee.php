<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
  <meta charset="UTF-8">
  <title><?php echo ($config['title']); ?></title>
  <meta name="keywords" content="<?php echo ($config['keywords']); ?>">
  <meta name="description" content="<?php echo ($config['description']); ?>">
  <link rel="icon" href="/Public/images/think.ico" type="image/x-icon">
  <link rel="icon" href="/Public/images/think.ico" type="image/x-icon">
  <link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="/Public/css/home/main.css" type="text/css" />
  <script src="/Public/js/jquery.js"></script>
  <script src="/Public/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- 头部导航 -->
  <header id="header">
  <div class="navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <a href="/">
          <img src="/Public/images/logo.png" alt="<?php echo ($config['title']); ?>">
        </a>
      </div>
      <ul class="nav navbar-nav navbar-left">
        <li><a href="/" <?php echo showStyle('Index');?>>首页</a></li>
        <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/Home/Cat/index?id='.$nav['menu_id']);?>"<?php echo showStyle(array('id'=>$nav['menu_id'],'getId'=>$_GET['id']));?>><?php echo ($nav['name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
</header>

  <!-- 主体 -->
  <section>
      <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-9">
        <div class="banner">
          <div class="banner-left">

            <!-- 轮播图开始 -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- 轮播（Carousel）指标 -->
              <ol class="carousel-indicators" >
                <?php if(is_array($bigPics)): foreach($bigPics as $key=>$bigPic): ?><li data-target="#myCarousel" data-slide-to="<?php echo ($key); ?>" <?php if(($key) == "0"): ?>class="active"<?php endif; ?>></li>&nbsp;&nbsp;<?php endforeach; endif; ?>
              </ol>
              <!-- 轮播（Carousel）项目 -->
              <div class="carousel-inner">
                <?php if(is_array($bigPics)): foreach($bigPics as $key=>$bigPic): ?><div <?php if(($key) == "0"): ?>class="item active"<?php else: ?>class="item"<?php endif; ?>>
                    <a target="_blank" href="<?php echo U('/Home/Detail/index?id='.$bigPic['article_id']);?>" title="<?php echo ($bigPic['title']); ?>">
                      <img style="width: 670px;height: 360px;" src="<?php echo ($bigPic['thumb']); ?>" alt="<?php echo ($bigPic['title']); ?>">
                    </a>
                    <div class="carousel-caption"><?php echo ($bigPic['title']); ?></div>
                  </div><?php endforeach; endif; ?>
              </div>
              <!-- 轮播（Carousel）导航 -->
              <a class="carousel-control left" href="#myCarousel"
                 data-slide="prev">&lsaquo;
              </a>
              <a class="carousel-control right" href="#myCarousel"
                 data-slide="next">&rsaquo;
              </a>
            </div>
            <!-- 轮播图结束 -->

          <!-- 小图推荐 -->
          </div>
          <div class="banner-right">
            <ul>
              <?php if(is_array($smaPics)): $i = 0; $__LIST__ = $smaPics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$smaPic): $mod = ($i % 2 );++$i;?><li>
                  <a target="_blank" href="<?php echo U('/Home/Detail/index?id='.$smaPic['posc_id']);?>" title="<?php echo ($smaPic['title']); ?>">
                    <img style="width: 150px;height: 113px;" src="<?php echo ($smaPic['thumb']); ?>" alt="<?php echo ($smaPic['title']); ?>">
                  </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <!-- 小图推荐结束 -->

        <div class="news-list">
          <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$new): $mod = ($i % 2 );++$i;?><dl>
              <dt><a target="_blank" href="<?php echo U('/Home/Detail/index?id='.$new['article_id']);?>" title="<?php echo ($new['title']); ?>"><?php echo ($new['title']); ?></a></dt>
              <dd class="news-img">
                <a target="_blank" href="<?php echo U('/Home/Detail/index?id='.$new['article_id']);?>" title="<?php echo ($new['title']); ?>"><img style="width: 200px;height: 120px;" src="<?php echo ($new['thumb']); ?>" alt="<?php echo ($new['title']); ?>"></a>
              </dd>
              <dd class="news-intro">
                <?php echo ($new['description']); ?>
              </dd>
              <dd class="news-info">
                关键词：<?php echo ($new['keywords']); ?> <span>时间：<?php echo (date('n月j日G时',$new['create_time'])); ?></span> <span attr-id="<?php echo ($new['article_id']); ?>" class="article-count node-<?php echo ($new['article_id']); ?>">阅读数（<?php echo ($new['count']); ?>）</span>
              </dd>
            </dl><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>

      <!-- 侧栏 -->
      <div class="col-sm-3 col-md-3">
  <div class="right-title">
    <h3>文章排行</h3>
    <span>TOP ARTICLES</span>
  </div>
  <div class="right-content">
    <?php if(is_array($topArticles)): $key = 0; $__LIST__ = $topArticles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$topArticle): $mod = ($key % 2 );++$key;?><li <?php if(($key) == "1"): ?>class="num1 curr"<?php else: ?>class="num<?php echo ($key); ?>"<?php endif; ?>>
        <a target="_blank" href="<?php echo U('/Home/Detail/index?id='.$topArticle['article_id']);?>" title="<?php echo ($topArticle['title']); ?>"><?php echo ($topArticle['title']); ?></a>
        <?php if(($key) == "1"): ?><div class="intro">
            <?php echo ($topArticle['small_title']); ?>
          </div>
        </else><?php endif; ?>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </div>

  <!-- 广告位 -->
  <?php if(is_array($ads)): $i = 0; $__LIST__ = $ads;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><div class="right-hot">
      <a target="_blank" href="<?php echo ($ad['url']); ?>" title="<?php echo ($ad['title']); ?>"><img src="<?php echo ($ad['thumb']); ?>" alt="<?php echo ($ad['title']); ?>"></a>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

    </div>
  </div>
  </section>

  <script src="/Public/js/admin/common.js"></script>
  <script src="/Public/js/jquery.js"></script>
  <script src="/Public/js/home/index.js"></script>
</body>
</html>