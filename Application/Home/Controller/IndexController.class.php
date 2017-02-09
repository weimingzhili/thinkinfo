<?php
namespace Home\Controller;

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
            $BasicModel = new \Admin\Model\BasicModel();
            $MenuModel = new \Admin\Model\MenuModel();
            $poscModel = new \Admin\Model\PositionContentModel();
            $ArticleModel = new \Admin\Model\ArticleModel();

            $navs = $MenuModel->getMenu(array('type'=>1,'status'=>1));
            $config = $BasicModel->getConfig();
            $bigPics = $poscModel->getPositionContent(array('status'=>1,'pos_id'=>2,'limit'=>4));
            $smaPics = $poscModel->getPositionContent(array('status'=>1,'pos_id'=>3,'limit'=>3));
            $news = $ArticleModel->getArticle(array('status'=>1,'thumb'=>array('neq','')),array('article_id,title,thumb,description,keywords,create_time,count'),3);
            $topArticles = $ArticleModel->getArticle(array('status'=>1),array('article_id,title,small_title'),5,'count desc,article_id');
            $ads = $poscModel->getPositionContent(array('status'=>1,'pos_id'=>5,'limit'=>2));
            $this->assign('ads',$ads);
            $this->assign('topArticles',$topArticles);
            $this->assign('smaPics',$smaPics);
            $this->assign('bigPics',$bigPics);
            $this->assign('navs',$navs);
            $this->assign('config',$config);
            $this->assign('news',$news);

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
            $admin = getUsername();
            if(empty($admin)) {
                return $this->error('您没有权限访问该页面！');
            }

            $user = $_POST['user'];
            if($admin == $user) {
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
                $where['article_id'] = array('in',$_POST['articleIdStr']) ;
                $articleModel = new \Admin\Model\ArticleModel();
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