<?php

namespace Admin\Model;

use Think\Model;

use Think\Page;

use Think\Exception;

/**
 * 推荐位内容操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class PositionContentModel extends Model {
        private $_db = '';

        public function __construct() {
            parent::__construct();

            $this->_db = M('position_content');
        }

        /**
         * 推荐位内容添加
         * @param int $id 推荐位id
         * @param array $data 文章数据
         * @return bool
         * @throws Exception
         */
        public function articlePush($id,$data) {
            if(isset($id,$data) && is_numeric($id) && is_array($data)) {
                // 写入数据库
                foreach($data as $article) {
                    $addData = array(
                        'pos_id' => intval($id),
                        'title' => $article['title'],
                        'thumb' => $article['thumb'],
                        'article_id' => $article['article_id'],
                        'status' => 1,
                        'create_time' => time(),
                    );

                    $addRes = $this->_db->add($addData);
                    if($addRes === false) {
                        $errIds[] = $article['article_id'];
                    }
                }

                if(empty($errIds)) {
                    return true;
                }

                return false;
            }

            throw new Exception('数据异常！');
        }

        /**
         * 推荐位内容分页
         * @param int $pageSize 每页记录数
         * @param array $where 查询条件
         * @return array
         * @throws Exception
         */
        public function positionContentPage($pageSize,$where) {
            // 获取总记录数
            $count = $this->_db->where($where)->count();
            // 获取分页导航
            $pageObj = new Page($count,$pageSize);
            $nav = $pageObj->show();
            // 获取分页记录
            $list = $this->_db->where($where)
                    ->order('list_id desc,posc_id desc')
                    ->limit($pageObj->firstRow.','.$pageObj->listRows)
                    ->select();

            return array('nav'=>$nav,'list'=>$list);
        }

        /**
         * 推荐位内容排序
         * @param array $data 排序数据
         * @return bool
         * @throws Exception
         */
        public function listOrder($data) {
            if(isset($data) && is_array($data)) {
                // 更新记录
                foreach($data as $id => $list) {
                    $where['posc_id'] = intval($id);
                    $list_id = intval($list);

                    $result = $this->_db->where($where)->setField('list_id',$list_id);
                    if($result === false) {
                        $errIds[] = $id;
                    }
                }

                if(empty($errIds)) {
                    return true;
                }

                return false;
            }

            throw new Exception('数据异常！');
        }

        /**
         * 检查推荐位内容数据
         * @param array $data
         * @return array|bool
         */
        public function positionContentCheck($data) {
            if(empty($data['title'])) {
                return array('status'=>0,'message'=>'请填写文章标题！');
            }
            if(empty($data['pos_id'])) {
                return array('status'=>0,'message'=>'请选择推荐位！');
            }
            if(empty($data['thumb'])) { // 当用户没有上传缩略图时，尝试从文章记录中获取
                if(!empty($data['article_id'])){
                    $article = D('Article')->getArticle(intval($data['article_id']));
                    if(!empty($article) && is_array($article)) {
                        $_POST['thumb'] = $article['thumb'];
                        return false;
                    }

                    return array('status'=>0,'message'=>'文章id不合法！');
                }

                return array('status'=>0,'message'=>'封面图和文章id不能同时为空！');
            }
            if(empty($data['url']) && empty($data['article_id'])) {
                return array('status'=>0,'message'=>'url和文章id不能同时为空！');
            }

            return false;
        }

        /**
         * 添加推荐位内容
         * @param array $data 推荐位内容数据
         * @return int
         * @throws Exception
         */
        public function positionContentAdd($data) {
            if(!empty($data) && is_array($data)) {
                $data['create_time'] = time();
                return $this->_db->add($data);
            }
            throw new Exception('数据异常！');
        }

        /**
         * 获取推荐位内容
         * @param int|array $data 查询条件
         * @return array
         */
        public function getPositionContent($data) {
            if(!empty($data)) {
                if(is_numeric($data)) {
                    $where['posc_id'] = intval($data);
                    return $this->_db->where($where)->find();
                }
                if(is_array($data)) {
                    $limit = $data['limit'];
                    unset($data['limit']);
                    $result = $this->_db->where($data)
                              ->order('list_id desc,posc_id desc')
                              ->limit($limit)
                              ->select();
                    return $result;
                }
            }

            return array();
        }

        /**
         * 更新推荐位
         * @param int $id 推荐位内容id
         * @param int|array $where 更新数据
         * @return int|bool
         * @throws Exception
         */
        public function poscUpdate($id,$where) {
            if(!empty($id) && isset($where)) {
                if(is_numeric($where)) {
                    $whereData['posc_id'] = intval($id);
                    $status = intval($where);
                    return $this->_db->where($whereData)->setField('status',$status);
                }

                if(is_array($where)) {
                    $whereData['posc_id'] = intval($id);
                    unset($where['posc_id']);
                    $where['update_time'] = time();

                    return $this->_db->where($whereData)->save($where);
                }

            }


            throw new Exception('数据不合法！');
        }
    }
