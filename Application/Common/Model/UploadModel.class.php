<?php
namespace Common\Model;

use Think\Model;

/**
 * 文件上传处理
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class UploadModel extends Model {
        // 上传目录
        const UPLOADPDIR = 'upload';
        private $_uploadObj = '';

        public function __construct() {
            $this->_uploadObj = new \Think\Upload();
            $this->_uploadObj->rootPath = './'.self::UPLOADPDIR.'/';
            $this->_uploadObj->subName = date('Ymd');
        }

        /**
         * 图片上传
         * @return bool|string
         */
        public function imageUpload() {
            $result = $this->_uploadObj->upload();
            if(!$result) {
                return false;
            }

            return '/'.self::UPLOADPDIR.'/'.$result['imgFile']['savepath'].$result['imgFile']['savename'];
        }
    }
