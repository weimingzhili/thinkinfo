<?php

namespace Admin\Model;

use Think\Model;

/**
 * 基本配置处理
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class BasicModel extends Model {
        public function __construct() {

        }

        /**
         * 检查配置
         * @param array $data
         * @return array|bool
         */
        public function configCheck($data) {
            if(!isset($data['title'])) {
                return array('status'=>0,'message'=>'站点标题不能为空！');
            }
            if(!isset($data['keywords'])) {
                return array('status'=>0,'message'=>'站点关键词不能为空！');
            }
            if(!isset($data['description'])) {
                return array('status'=>0,'message'=>'站点描述不能为空！');
            }

            return false;
        }

        /**
         * 配置缓存
         * @param array $data
         * @return mixed
         */
        public function configSave($data) {
            if(!empty($data) && is_array($data)) {
                $config = array();
                foreach($data as $name => $value) {
                    $config[$name] = htmlspecialchars(trim($value));
                }

                return F('site_config',$config);
            }

            return false;
        }

        /**
         * 获取配置缓存
         * return mixed
         */
        public function getConfig() {
            return F('site_config');
        }
    }
