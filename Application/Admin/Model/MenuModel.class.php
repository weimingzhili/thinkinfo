<?php

namespace Admin\Model;

use Think\Model;

use Think\Page;

use Think\Exception;

/**
 * 菜单操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class MenuModel extends Model {

        private $_db = '';

        public function __construct() {
            parent::__construct();
            $this->_db = M('menu');
        }

        /**
         * 获取菜单
         * @param integer|array $where 查询条件
         * @return array
         */
        public function getMenu($where) {
            // 获取多条菜单
            if(!empty($where) && is_array($where)) {
                $result = $this->_db->where($where)
                    ->order('list_id desc,menu_id desc')
                    ->select();
                return $result;
            }

            // 获取单条菜单
            if(!empty($where) && is_numeric($where)) {
                $id = intval($where);
                return $this->_db->find($id);
            }

            return array();
        }

        /**
         * 菜单分页
         * @param array $where 查询条件
         * @param integer $pageSize 每页显示记录数
         * @return array
         */
        public function menuPages($where,$pageSize) {
            // 获取分页
            $count = $this->_db->where($where)->count();
            $page = new Page($count,$pageSize);
            $show = $page->show();

            // 分页数据查询
            $list = $this->_db->where($where)
                    ->order('list_id desc, menu_id desc')
                    ->limit($page->firstRow.','.$page->listRows)
                    ->select();

            // 将数据打包返回
            return array('show'=>$show,'list'=>$list);
        }

        /**
         * 菜单排序
         * @param integer $menu_id
         * @param integer $listorder
         * @return integer|boolean
         * @throws Exception
         */
        public function listUpdate($menu_id,$listorder) {
            if(!isset($menu_id) || !is_numeric($menu_id)) {
                throw new Exception('id不合法');
            }
            if(!isset($listorder) || !is_numeric($listorder)) {
                throw new Exception('排序的id不合法');
            }

            $where['menu_id'] = $menu_id;
            $data['list_id'] = intval($listorder);
            return $this->_db->where($where)->save($data);
        }

        /**
         * 检查菜单
         * @param array $menuData 菜单数据
         * @return array|boolean
         */
        public function checkMenu($menuData) {
            if(empty($menuData['name'])) {
                Return array('status'=>0,'message'=>'菜单名不能为空');
            }
            if(empty($menuData['m'])) {
                Return array('status'=>0,'message'=>'模块名不能为空');
            }
            if(empty($menuData['c'])) {
                Return array('status'=>0,'message'=>'控制器名不能为空');
            }
            if(empty($menuData['f'])) {
                Return array('status'=>0,'message'=>'方法不能为空');
            }

            return false;
        }

        /**
         * 添加菜单
         * @param array $data 写入的数据
         * @return integer|boolean
         * @throws Exception
         */
        public function menuAdd($data) {
            if(empty($data)) {
                throw new Exception('菜单数据为空');
            }

            $data['m'] = ucfirst(strtolower($data['m']));
            $data['c'] = ucfirst(strtolower($data['c']));

            return $this->_db->add($data);
        }

        /**
         * 更新菜单
         * @param integer $menu_id 菜单id
         * @param array $menuData 菜单数据
         * @return integer|boolean
         * @throws Exception
         */
        public function updateMenu($menu_id,$menuData) {
            // 检查数据
            if(empty($menu_id) || !is_numeric($menu_id)) {
                throw new Exception('数据不合法');
            }
            if(empty($menuData) || !is_array($menuData)) {
                throw new Exception('数据不合法');
            }

            $where['menu_id'] = intval($menu_id);
            return $this->_db->where($where)->save($menuData);
        }

        /**
         * 获取菜单总数
         * @return integer 返回有效菜单总数
         */
        public function getTotal()
        {
            return $this->_db->where(['status' => 1])->count();
        }
    }
