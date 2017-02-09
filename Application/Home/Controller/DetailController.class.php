<?php
namespace Home\Controller;

use Think\Exception;

/**
 * 文章详情显示
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class DetailController extends CommonController {
        /**
         * 输出文章详情页
         */
        public function index() {
            if(!empty($_GET['id'])) {
                if(is_numeric($_GET['id']) && $_GET['id'] > 0) {
                    $id = intval($_GET['id']);
                    $articleModel = new \Admin\Model\ArticleModel();
                    $articleContentModel = new \Admin\Model\ArticleContentModel();
                    $articleData = $articleModel->getArticle($id);

                    if(empty($articleData) || $articleData['status'] != 1) {
                        return $this->error('请求的页面不存在！');
                    }

                    $articleContent = $articleContentModel->getContent($id);
                    if(empty($articleContent)) {
                        return $this->error('请求的页面不存在！');
                    }
                    $content = htmlspecialchars_decode($articleContent);

                    try {
                        $count = $articleData['count'] + 1;
                        $updateRes = $articleModel->update($id,$count);
                        if($updateRes) {
                            $menuModel = new \Admin\Model\MenuModel();
                            $basicModel = new \Admin\Model\BasicModel();
                            $posCModel = new \Admin\Model\PositionContentModel();

                            $navs = $menuModel->getMenu(array('status'=>1,'type'=>1));
                            $config = $basicModel->getConfig();
                            $topArticles = $articleModel->getArticle(array('status' => 1),array('article_id,title,small_title'), 10, 'count desc,article_id');;
                            $ads = $posCModel->getPositionContent(array('status' => 1, 'pos_id' => 5, 'limit' => 2));

                            $this->assign(array(
                                'article' => $articleData,
                                'content' => $content,
                                'navs' => $navs,
                                'config' => $config,
                                'topArticles' => $topArticles,
                                'ads' => $ads,
                            ));
                            $this->display('index');
                        } else {
                            return $this->error('系统发生错误！');
                        }
                    } catch(Exception $e) {
                        return $this->error($e->getMessage());
                    }
                } else {
                    return $this->error('文章id不合法！');
                }
            } else {
                return $this->error('请求的页面不存在！');
            }
        }

        /**
         * 文章预览
         */
        public function view() {
            $user = getUsername();
            if(empty($user)) {
                return $this->error('您没有权限访问该页面！');
            }

            $this->index();
        }
    }
