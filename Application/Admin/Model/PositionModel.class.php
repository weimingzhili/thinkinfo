<?php
namespace Admin\Model;

use Think\Exception;

use Think\Model;

use Think\Page;

/**
 * 推荐位操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class PositionModel extends Model {
        private $_db = '';

        public function __construct() {
            parent::__construct();

            $this->_db = M('position');
        }

        /**
         * 推荐位分页查询
         * @param array $where
         * @return array
         */
        public function positionPage($where) {
            $pageSize = 2;      // 每页显示的记录数
            $count = $this->_db->where($where)->count();    // 获取记录总数

            $page = new Page($count,$pageSize);     // 实例化分页类
            $nav = $page->show();       // 获取分页导航

            // 获取分页数据
            $list = $this->_db->where($where)
                ->order('pos_id desc')
                ->limit($page->firstRow.','.$page->listRows)
                ->select();

            return array('nav'=>$nav,'list'=>$list);
        }

        /**
         * 检查推荐位数据
         * @param array $data 推荐位数据
         * @return array|bool
         */
        public function positionCheck($data) {
            if(!isset($data['pos_name'])) {
                return array('status'=>0,'message'=>'请填写推荐位名称!');
            }
            if(!isset($data['status'])) {
                return array('status'=>0,'message'=>'请选择推荐位状态!');
            }

            return false;
        }

        /**
         * 添加推荐位
         * @param array $data 推荐位数据
         * @return int|bool
         * @throws Exception
         */
        public function positionAdd($data) {
            if(isset($data) && is_array($data) && in_array($data['status'],array(0,1))) {
                $addData['mame'] = htmlspecialchars($data['name']);
                $addData['description'] = $data['description']
                                        ? htmlspecialchars($data['description'])
                                        : '';
                $addData['create_time'] = time();
                return $this->_db->add($addData);
            }

            throw new Exception('数据异常！');
        }

        /**
         * 获取推荐位
         * @param array $whereData 查询条件
         * @return array
         */
        public function getPosition($whereData) {
            if(isset($whereData)) {
                if(is_numeric($whereData)) {
                    $where['pos_id'] = intval($whereData);
                    return $this->_db->where($where)->find();
                }
                if(is_array($whereData)) {
                    return $this->_db->where($whereData)->select();
                }
            }

            return array();
        }

        /**
         * 更新推荐位
         * @param int $id 推荐位id
         * @param array $data 推荐位数据
         * @return int|bool
         * @throws Exception
         */
        public function positionUpdate($id,$data) {
            if(isset($id,$data) && is_numeric($id)) {
                if(in_array($data,array(-1,0,1))) {
                    $where['pos_id'] = intval($id);
                    $status = $data;

                    return $this->_db->where($where)->setField('status',$status);
                }
                if(is_array($data)) {
                    unset($data['pos_id']);
                    $where['pos_id'] = intval($id);
                    $updateData['pos_name'] = htmlspecialchars($data['pos_name']);
                    $updateData['description'] = $data['description']
                        ? htmlspecialchars($data['description'])
                        : '';
                    $updateData['status'] = intval($data['status']);
                    $updateData['update_time'] = time();

                    return $this->_db->where($where)->save($updateData);
                }
            }

            throw new Exception('数据异常！');
        }


        /**
         * 获取有效推荐位总数
         * @return integer 有效推荐位总数
         */
        public function getTotal()
        {
            return $this->_db->where(['status' => 1])->count();
        }
    }