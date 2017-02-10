<?php
/**
 * 公共函数
 * @author WeiZeng <weimingzhili@gmail.com>
 */

    /**
     * 密码加密
     * @param string $password 加密前的密码
     * @return string 加密后的密码
     */
    function getMd5Password($password) {
        return md5(C('MD5_PRE').$password);
    }

    /**
     * 输出样式
     * @param string|array $data 需要判断的数据
     * @return string
     */
    function showStyle($data) {
        if(is_array($data)) {
            if($data['id'] == $data['getId']) {
                return 'class="curr"';
            }

            return '';
        }

        if(is_string($data)) {
            if(strtolower(MODULE_NAME) == 'home') {
                if(strtolower(CONTROLLER_NAME) == strtolower($data)) {
                    return 'class="curr"';
                }

                return '';
            }
            if(strtolower(MODULE_NAME) == 'admin') {
                if(strtolower(CONTROLLER_NAME) == strtolower($data)) {
                    return 'class="active"';
                }

                return '';
            }
        }

        return '';
    }

    /**
     * 获取菜单类型
     * @param integer $type 菜单类型值
     * @return string
     */
    function getMenuType($type) {
        return $type == 1 ? '前端栏目' : '后台菜单';
    }

    /**
     * 获取状态
     * @param integer $status 菜单状态值
     * @return string
     */
    function getStatus($status) {
        return $status == 1 ? '开启' : '关闭';
    }

    /**
     * 获取栏目名
     * @param array $homeMenus 前端栏目
     * @param integer $cat_id 栏目id
     * @return string
     */
    function getCatName($homeMenus,$cat_id) {
        $catList = array();
        foreach($homeMenus as $cats) {
            $catList[$cats['menu_id']] = $cats['name'];
        }

        return $catList[$cat_id] ? $catList[$cat_id] : '';
    }

    /**
     * 判断缩图
     * @param string $thumb 缩图url
     * @return string
     */
    function checkThumb($thumb) {
        if(!empty($thumb)) {
            return '有';
        }

        return '无';
    }

    /**
     * 判断创建、更新时间
     * @param string $timestamp 时间戳
     * @return string
     */
    function checkTime($timestamp) {
        if(!empty($timestamp)) {
            return date('Y-m-d H:i',$timestamp);
        }

        return '无';
    }

    /**
     * 获取登录用户名
     * @return string
     */
    function getUsername() {
        $admin = session('admin');
        if(isset($admin) && is_array($admin)) {
            return $admin['username'] ? $admin['username'] : '';
        }

        return '';
    }

    /**
     * 显示缩略图
     * @param string $thumb 缩略图
     * @return string
     */
    function showThumb($thumb) {
        if($thumb) {
            return 'display:inline;width:50%;';
        }

        return 'display:none;';
    }

    /**
     * 获取推荐位名称
     * @param int $id 推荐位id
     * @param array $data 推荐位数据
     * @return string
     */
    function getPositionName($id,$data) {
        $positions = array();
        foreach($data as $position) {
            $positions[$position['pos_id']] = $position['pos_name'];
        }

        return $positions[$id] ? $positions[$id] : '';
    }
