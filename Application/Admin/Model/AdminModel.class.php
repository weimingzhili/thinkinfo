<?php
namespace Admin\Model;

use Think\Exception;

use Think\Model;

use Think\Page;

/**
 * 管理员操作
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class AdminModel extends Model {
        private $_db = '';

        public function __construct() {
            parent::__construct();
            $this->_db = M('admin');
        }

        /**
         * 获取用户记录
         * @param int|string $data 查询条件
         * @return array
         */
        public function getAdmin($data) {
            if(!empty($data)) {
                if(is_numeric($data)) {
                    $where['admin_id'] = intval($data);
                    return $this->_db->where($where)->find();
                } else {
                    $where['username'] = $data;
                    $where['status'] = array('neq',-1);
                    return $this->_db->where($where)->find();
                }
            }

            return array();
        }

        /**
         * 获取用户分页数据
         * @param array $where 查询条件
         * @param int $pageSize 每页记录数
         * @return array
         */
        public function adminPage($where,$pageSize) {
            // 获取分页记录总数
            $count = $this->_db->where($where)->count();
            // 获取分页导航
            $pageObj = new Page($count,$pageSize);
            $nav = $pageObj->show();
            //获取分页数据
            $list = $this->_db->where($where)
                    ->order('admin_id desc')
                    ->limit($pageObj->firstRow.','.$pageObj->listRows)
                    ->select();

            return array('list'=>$list,'nav'=>$nav);
        }

        /**
         * 检查用户数据
         * @param array $data 数据
         * @return bool|array
         */
        public function adminCheck($data) {
            if(empty($data['username']) || !trim($data['username'])) {
                return array('status'=>0,'message'=>'用户名不能为空！');
            }
            if(empty($data['password']) || !trim($data['password'])) {
                return array('status'=>0,'message'=>'密码不能为空！');
            }
            if(empty($data['realname'])) {
                return array('status'=>0,'message'=>'状态不能为空！');
            }
            if(empty($data['email'])) {
                return array('status'=>0,'message'=>'email不能为空！');
            }

            return false;
        }

        /**
         * 添加用户
         * @param array $data 添加数据
         * @return array
         * @throws Exception
         */
        public function adminAdd($data) {
            if(!empty($data) && is_array($data)) {
                $addData['username'] = htmlspecialchars($data['username']);
                $addData['password'] = md5(htmlspecialchars($data['password'].C('MD5_PRE')));
                $addData['status'] = 1;
                $addData['realname'] = htmlspecialchars($data['realname']);
                $addData['email'] = htmlspecialchars($data['email']);
                $addData['create_time'] = time();

                return $this->_db->field(array('username','password','status','realname','email','create_time'))->add($addData);
            }

            throw new Exception('数据异常！');
        }

        /**
         * 更新用户
         * @param array $whereData 查询条件
         * @param array $data 更新数据
         * @param string $field 查询字段
         * @return array
         * @throws Exception
         */
        public function adminUpdate($whereData,$data,$field='lastloginip,lastlogintime') {
            if(isset($data,$whereData)) {
                if(is_numeric($whereData) && in_array($data,array(-1,0,1))) {
                    $where['admin_id'] = $whereData;
                    return $this->_db->where($where)->setField('status',$data);
                }
                if(is_string($whereData) && is_array($data)) {
                    $where['username'] = $whereData;
                    $result = $this->_db->where($where)
                              ->field($field)
                              ->save($data);
                    return $result;
                }
            }

            throw new Exception("数据不合法！");
        }

        /**
         * 获取有效管理员总数
         * @return integer
         */
        public function getTotal()
        {
            return $this->_db->where(['status' => 1])->count();
        }
    }
