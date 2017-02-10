<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 文件上传
 * @author WeiZeng <weimingzhili@gmail.com>
 */
    class UploadController extends Controller {
        /**
         * 图片上传
         * @return array
         */
        public function imageUpload() {
            $uploadRes = D('Upload')->imageUpload();
            if($uploadRes === false) {
                $this->ajaxReturn(array('error'=>1,'url'=>''));
            }

            $this->ajaxReturn(array('error'=>0,'url'=>$uploadRes));
        }
    }
