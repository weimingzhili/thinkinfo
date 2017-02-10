<?php

namespace Admin\Controller;

use Think\Exception;

/**
 * 文章管理
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class ArticleController extends CommonController {
        /**
         * 输出列表页
         */
        public function index() {
            // 获取前端栏目
            $where = array('type'=>1,'status'=>1);
            $homeMenus = D('Menu')->getMenu($where);

            // 文章搜索
            if(!empty($_GET)) {
                if(!empty($_GET['catId']) && is_numeric($_GET['catId'])) {
                    $cat_id = intval($_GET['catId']);
                    $where['cat_id'] = $cat_id;
                    $this->assign('cat_id',$cat_id);
                }

                if(!empty($_GET['title'])  && is_string($_GET['title'])) {
                    $title = htmlspecialchars($_GET['title']);
                    $where['title'] = array('like','%'.$_GET['title'].'%');
                    $this->assign('title',$title);
                }
            }

            // 获取文章分页
            $where['status'] = array('neq',-1);
            $pageNum = 3;
            $page = D('Article')->articlePage($where,$pageNum);

            // 获取推荐位
            $positions = D('Position')->getPosition(array('status'=>1));

            $this->assign(array(
                'homeMenus' => $homeMenus,
                'positions' => $positions,
                'pageList'  => $page['pageList'],
                'pageNav'   => $page['pageNav'],
            ));
            $this->display();
        }

        /**
         * 文章排序
         * @return array
         */
        public function listOrder() {
            if(!empty($_POST)) {
                $articleModel = D('Article');
                $errors = array();
                $url = $_SERVER['HTTP_REFERER'];

                // 更新数据
                try {
                    foreach($_POST as $article_id => $list_id) {
                        $listRes = $articleModel->listOrder($article_id,$list_id);
                        if($listRes === false) {
                            $errors[] = $listRes;
                            }
                    }

                    // 判断更新结果
                    if(empty($errors)) {
                        $this->ajaxReturn(array('status'=>1,'url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'排序失败'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }

        /**
         * 文章添加
         * @return array
         */
        public function add() {
            // 判断用户是否添加
            if(!empty($_POST)) { // 当POST数据不为空时，认为用户执行的是添加操作
                try {
                    $articleModel = D('Article');
                    $articleContentModel = D('ArticleContent');

                    // 检查数据
                    $checkRes = $articleModel->checkArticle($_POST);
                    if ($checkRes) {
                        $this->ajaxReturn($checkRes);
                    }

                    // 将数据添加到文章主表
                    $addRes = $articleModel->articleAdd($_POST);
                    if ($addRes) {  // 如果主表添加成功，再添加数据到副表
                        $article_id = $addRes;
                        $content = $_POST['content'];
                        $result = $articleContentModel->contentAdd($article_id, $content);
                        if ($result) {
                            $this->ajaxReturn(array('status' => 1, 'message' => '添加成功'));
                        }

                        $this->ajaxReturn(array('status' => 0, 'message' => '添加失败'));
                    }

                    $this->ajaxReturn(array('status' => 0, 'message' => '添加失败'));
                } catch (Exception $e) {
                    $this->ajaxReturn(array('status' => 0, 'message' => $e->getMessage()));
                }

            } else { // 输出文章添加页面
                $homeMenu = D('Menu')->getMenu(array('type'=>1,'status'=>1));
                $admin = getUsername();
                $this->assign([
                    'admin'    => $admin,
                    'homeMenu' => $homeMenu,
                ]);
                $this->display();
            }
        }

        /**
         * 文章编辑
         * @return array
         */
        public function edit() {
            if(isset($_POST['article_id'])) { // 当POST数据中存在article_id时，认为用户在保存数据
                // 检查数据
                try {
                    $articleModel = D('Article');
                    $checkRes = $articleModel->checkArticle($_POST);
                    if($checkRes) {
                        $this->ajaxReturn($checkRes);
                    }
                    // 更新文章表
                    $updateRes = $articleModel->updateArticle($_POST['article_id'],$_POST);
                    if($updateRes !== false) { // 在更新文章表成功的情况下再更新文章内容表
                        $result = D('ArticleContent')->updateContent($_POST['article_id'],$_POST['content']);
                        if($result ===false) {
                            $this->ajaxReturn(array('status'=>0,'message'=>'文章内容更新失败'));
                        }

                        $this->ajaxReturn(array('status'=>1,'message'=>'操作成功！为您跳转到文章列表页面'));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'文章更新失败'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            } else { // 输出编辑菜单页面
                $article = D('Article')->getArticle($_GET['id']);
                $content = D('ArticleContent')->getContent($_GET['id']);
                $admin = getUsername();
                $cat = D('Menu')->getMenu(array('type'=>1,'status'=>1));
                $this->assign(array(
                    'article'    => $article,
                    'content'    => $content,
                    'admin'      => $admin,
                    'cat'        => $cat,
                ));
                $this->display();
            }
        }

        /**
         * 更新文章状态
         * @return array
         */
        public function update() {
            if(isset($_POST['id'],$_POST['status'])) {
                // 获取数据
                $article_id = $_POST['id'];
                $status = $_POST['status'];
                $url = $_SERVER['HTTP_REFERER'];

                // 更新记录
                try {
                    $updateRes = D('Article')->updateStatus($article_id,$status);
                    if($updateRes) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'修改成功','url'=>$url));
                    }

                    $this->ajaxReturn(array('status'=>0,'message'=>'更新状态失败1'));
                } catch(Exception $e) {
                    $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                }
            }
        }

        /**
         * 文章推送
         * @return array
         */
        public function push() {
            if(!empty($_POST['articleIdStr']) && !empty($_POST['pos_id'])) {
                // 获取文章id和推荐位id
                $url = $_SERVER['HTTP_REFERER'];
                $articleIdStr = $_POST['articleIdStr'];
                $pos_id = $_POST['pos_id'];

                // 检查推荐位id
                if(is_numeric($pos_id)) {
                    $where['article_id'] = array('in',$articleIdStr);
                    $articles = D('Article')->getArticle($where);

                    // 判断文章数据
                    if(empty($articles)) {
                        $this->ajaxReturn(array('status'=>0,'message'=>'数据异常！'));
                    }

                    // 推送文章
                    try {
                        $addRes = D('PositionContent')->articlePush($pos_id,$articles);
                        if($addRes) {
                            $this->ajaxReturn(array('status'=>1,'url'=>$url));
                        }

                        $this->ajaxReturn(array('status'=>0,'message'=>'推送失败！'));
                    } catch(Exception $e) {
                        $this->ajaxReturn(array('status'=>0,'message'=>$e->getMessage()));
                    }
                }

                $this->ajaxReturn(array('status'=>0,'message'=>'数据异常！'));
            }
        }
    }
