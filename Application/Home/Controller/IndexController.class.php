<?php

namespace Home\Controller;

use Admin\Model\BasicModel;

use Admin\Model\MenuModel;

use Admin\Model\PositionContentModel;

use Admin\Model\ArticleModel;

/*
 * 首页
 */
    class IndexController extends CommonController {
        /**
         * 输出首页
         * @param string $type
         * @return mixed
         */
        public function index($type = ''){
            $BasicModel = new BasicModel();
            $MenuModel = new MenuModel();
            $poscModel = new PositionContentModel();
            $ArticleModel = new ArticleModel();

            // 获取栏目、配置、推荐位内容和文章数据
            $navs = $MenuModel->getMenu(array('type'=>1,'status'=>1));
            $config = $BasicModel->getConfig();
            $bigPics = $poscModel->getPositionContent(array('status'=>1,'pos_id'=>2,'limit'=>4));
            $smaPics = $poscModel->getPositionContent(array('status'=>1,'pos_id'=>3,'limit'=>3));
            $news = $ArticleModel->getArticle(array('status'=>1,'thumb'=>array('neq','')),array('article_id,title,thumb,description,keywords,create_time,count'),3);
            $topArticles = $ArticleModel->getArticle(array('status'=>1),array('article_id,title,small_title'),5,'count desc,article_id');
            $ads = $poscModel->getPositionContent(array('status'=>1,'pos_id'=>5,'limit'=>2));
            $this->assign(array(
                'ads' => $ads,
                'topArticles' => $smaPics,
                'smaPics' => $smaPics,
                'bigPics' => $bigPics,
                'navs' => $navs,
                'config' => $config,
                'news' => $news,
            ));

            if($type == 'buildIndexHtml') {
                return $this->buildHtml('index',HTML_PATH,'index');
            } else {
                $this->display();
            }
        }


        /**
         * 首页静态化
         * @return array
         */
        public function buildIndexHtml() {
            $user = $_POST['user'];
            if(!empty($user)) {
                $result = $this->index('buildIndexHtml');
                if(!empty($result)) {
                    $this->ajaxReturn(array('status'=>1,'message'=>'首页缓存成功！'));
                }

                $this->ajaxReturn(array('status'=>0,'message'=>'首页缓存失败！'));
            }

            return $this->error('您没有权限访问该页面！');
        }

        /**
         * 加载阅读数
         * @return array
         */
        public function getCount() {
            if(!empty($_POST['articleIdStr'])) {
                // 获取文章阅读数
                $where['article_id'] = array('in',$_POST['articleIdStr']) ;
                $articleModel = new ArticleModel();
                $counts = $articleModel->getArticle($where,'article_id,count',10);
                if(!empty($counts)) {
                    $data = array();
                    foreach($counts as $key => $value) {
                        $data[$value['article_id']] = $value['count'];
                    }

                    $this->ajaxReturn(array('status'=>1,'data'=>$data));
                } else {
                 return $this->error('系统发生错误');
                }
            } else {
                return $this->error('系统发生错误');
            }
        }
    }
