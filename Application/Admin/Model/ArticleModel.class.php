<?php

namespace Admin\Model;

use Think\Model;

use Think\Exception;

/**
 * 文章操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class ArticleModel extends Model {
        private $_db = '';

        public function __construct() {
            parent::__construct();

            $this->_db = M("article");
        }

        /**
         * 文章分页
         * @param array $where 查询条件
         * @param integer $pageNum 每页显示的记录数
         * @return array
         */
        public function articlePage($where,$pageNum) {
            // 获取分页导航
            $count = $this->_db->where($where)->count();
            $page = new \Think\Page($count,$pageNum);
            $pageNav = $page->show();

            // 获取分页数据
            $pageList = $this->_db->where($where)
                ->order('list_id desc,article_id desc')
                ->limit($page->firstRow.','.$page->listRows)
                ->select();

            return array('pageNav'=>$pageNav,'pageList'=>$pageList);
        }

        /**
         * 文章排序
         * @param integer $article_id 文章id
         * @param integer $list_id 排序id
         * @return integer|bool
         * @throws \Think\Exception
         */
        public function listOrder($article_id,$list_id) {
            // 检查数据
            if(!isset($article_id) || !is_numeric($article_id)) {
                throw new Exception('操作失败');
            }
            if(!isset($list_id) || !is_numeric($list_id)) {
                throw new Exception('操作失败');
            }

            $where['article_id'] = intval($article_id);
            return $this->_db->where($where)->setField('list_id',intval($list_id));
        }

        /**
         * 检查文章
         * @param array $article 文章数据
         * @return array|bool
         */
        public function checkArticle($article) {
            if(!isset($article['title'])) {
                return array('status'=>0,'message'=>'文章标题不能为空');
            }
            if(!isset($article['small_title'])) {
                return array('status'=>0,'message'=>'短标题不能为空');
            }
            if(!isset($article['cat_id'])) {
                return array('status'=>0,'message'=>'栏目不能为空');
            }
            if(!isset($article['content'])) {
                return array('status'=>0,'message'=>'文章内容不能为空');
            }
            if(!isset($article['keywords'])) {
                return array('status' => 0, 'message' => '关键词不能为空');
            }

            return false;
        }

        /**
         * 添加文章
         * @param array $data 文章数据
         * @return integer
         * @throws \Think\Exception
         */
        public function articleAdd($data) {
            // 检查数据
            if(!isset($data) || !is_array($data)) {
                throw new Exception('操作异常');
            }

            $data['create_time'] = time();
            return $this->_db->add($data);
        }

        /**
         * 获取文章
         * @param int|array $whereData 查询条件
         * @param string|array $field 查询的字段
         * @param int $num 获取的记录总数
         * @param string $order 排序顺序
         * @return array
         */
        public function getArticle($whereData,$field='*',$num=5,$order='list_id desc,article_id desc') {
            if(isset($whereData)) {
                if(is_numeric($whereData)) {
                    $where['article_id'] = intval($whereData);
                    return $this->_db->where($where)->find();
                }
                if(is_array($whereData)) {
                    $result = $this->_db->where($whereData)
                              ->field($field)
                              ->order($order)
                              ->limit($num)
                              ->select();
                    return $result;
                }
            }

            return array();
        }

        /**
         * 更新文章
         * @param integer $id   文章id
         * @param array $data 文章数据
         * @return integer
         * @throws \Think\Exception
         */
        public function updateArticle($id,$data) {
            if(isset($id,$data) && is_numeric($id) && is_array($data)) {
                $where['article_id'] = intval($id);
                $data['user'] = getUsername();
                $data['update_time'] = time();
                return $this->_db->where($where)->save($data);
            }

            throw new Exception('文章数据不合法');
        }

        /**
         * 更新文章状态
         * @param integer $id 文章id
         * @param integer $status 文章状态
         * @return integer|bool
         * @throws \Think\Exception
         */
        public function updateStatus($id,$status) {
            if(isset($id,$status) && is_numeric($id) && is_numeric($status)) {
                $where['article_id'] = intval($id);
                $status = intval($status);
                return $this->_db->where($where)->setField('status',$status);
            }

            throw new Exception('更改文章状态数据不合法');
        }

        /**
         * @param int $id 文章id
         * @param int|array $data 更新数据
         * @param string $column 字段名，默认count
         * @return bool|array
         * @throws Exception
         */
        public function update($id,$data,$column='count') {
            // 检查数据
            if(isset($id,$data) && is_numeric($id)) {
                if(is_numeric($data)) {
                    $where['article_id'] = intval($id);
                    $updateData = intval($data);

                    return $this->_db->where($where)->setField($column,$updateData);
                }
                if(is_array($data)) {
                    $where['article_id'] = intval($id);
                    $updateData['user'] = getUsername();
                    $updateData['update_time'] = time();

                    return $this->_db->where($where)->save($updateData);
                }
            }

            throw new Exception('数据不合法！');
        }

        /**
         * 获取文章总数
         * @return integer
         */
        public function getTotal() {
            return $this->_db->where(['status' => 1])->count();
        }

    }
