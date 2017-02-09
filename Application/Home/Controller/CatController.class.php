<?php
namespace Home\Controller;

/**
 * 栏目管理
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class CatController extends CommonController {
        /**
         * 输出栏目页
         * @return array
         */
        public function index() {
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                if (!is_numeric($id)) {
                    return $this->error('栏目id不合法');
                }

                $menuModel = new \Admin\Model\MenuModel();
                $cat = $menuModel->getMenu(intval($id));
                if (empty($cat) || $cat['type'] != 1 || $cat['status'] != 1) {
                    return $this->error('请求的页面不存在！');
                }


                $basicModel = new \Admin\Model\BasicModel();
                $articleModel = new \Admin\Model\ArticleModel();
                $poscModel = new \Admin\Model\PositionContentModel();

                $navs = $menuModel->getMenu(array('status' => 1, 'type' => 1));
                $config = $basicModel->getConfig();
                $topArticles = $articleModel->getArticle(array('status' => 1),array('article_id,title,small_title'), 5, 'count desc,article_id');
                $ads = $poscModel->getPositionContent(array('status' => 1, 'pos_id' => 5, 'limit' => 2));
                $listArticles = $articleModel->articlePage(array('status'=>1,'thumb'=>array('neq',''),'cat_id'=>$id),5);

                $this->assign(array(
                    'listArticles' => $listArticles['pageList'],
                    'listShow'     => $listArticles['pageNav'],
                    'config'       => $config,
                    'navs'         => $navs,
                    'topArticles'  => $topArticles,
                    'ads'          => $ads,
                ));
                $this->display();
            } else {
                return $this->error('你请求的页面不存在！');
            }
        }
    }