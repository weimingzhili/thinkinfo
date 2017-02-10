<?php

namespace Home\Controller;

use Admin\model\MenuModel;

use Admin\model\BasicModel;

use Admin\model\ArticleModel;

use Admin\Model\PositionContentModel;

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

                $menuModel = new MenuModel();
                $cat = $menuModel->getMenu(intval($id));
                if (empty($cat) || $cat['type'] != 1 || $cat['status'] != 1) {
                    return $this->error('请求的页面不存在！');
                }


                $basicModel = new BasicModel();
                $articleModel = new ArticleModel();
                $poscModel = new PositionContentModel();
                // 获取栏目数据
                $navs = $menuModel->getMenu(array('status' => 1, 'type' => 1));
                // 获取配置数据
                $config = $basicModel->getConfig();
                // 获取文章数据
                $topArticles = $articleModel->getArticle(array('status' => 1),array('article_id,title,small_title'), 5, 'count desc,article_id');
                // 获取推荐位内容数据
                $ads = $poscModel->getPositionContent(array('status' => 1, 'pos_id' => 5, 'limit' => 2));
                // 获取文章分页数据
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
