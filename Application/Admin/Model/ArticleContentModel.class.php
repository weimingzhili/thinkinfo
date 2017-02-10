<?php

namespace Admin\Model;

use Think\Model;

use Think\Exception;

/**
 * 文章内容处理
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class ArticleContentModel extends Model {
        private $_db = '';

        public function __construct() {
            $this->_db = M('article_content');
        }

        /**
         * 文章内容添加
         * @param int $article_id 文章id
         * @param string $content 文章内容
         * @return array
         * @throws Exception
         */
        public function contentAdd($article_id,$content) {
            // 检查数据
            if(!isset($article_id) || !is_numeric($article_id)) {
                throw new Exception('操作异常');
            }
            if(!isset($content) || !is_string($content)) {
                throw new Exception('操作异常');
            }

            // 过滤数据
            $data['article_id'] = $article_id;
            $data['content'] = htmlspecialchars($content);

            return $this->_db->add($data);
        }

        /**
         * 获取文章内容
         * @param integer $id 文章id
         * @return array
         */
        public function getContent($id) {
            if(isset($id) || is_numeric($id)) {
                $where['article_id'] = intval($id);
                return $this->_db->where($where)->getField('content');
            }

            return array();
        }

        /**
         * 更新文章内容
         * @param integer $id 文章id
         * @param string $content 文章内容
         * @return integer
         * @throws \Think\Exception
         */
        public function updateContent($id,$content) {
            if(isset($id,$content) && is_numeric($id)) {
                $where['article_id'] = intval($id);
                $content = htmlspecialchars($content);
                return $this->_db->where($where)->setField('content',$content);
            }

            throw new Exception('文章内容不合法！');
        }
    }
