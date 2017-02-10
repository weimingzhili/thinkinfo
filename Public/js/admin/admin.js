/*
    用户管理
 */

    // 跳转到用户添加页面
    $("#user-list-add").click(function() {
        window.location.href = common.adminAdd;
    });

    // 检查数据
    function check(data) {
        if(!data["username"]) {
            return "用户名不能为空！";
        }
        if(!data["password"]) {
            return "密码不能为空！";
        }
        if(!data["realname"]) {
            return "真实姓名不能为空！";
        }
        if(!data["email"]) {
            return "邮箱不能为空！";
        }

        return false;
    }

    // 用户添加
    $("#user-add-submit").click(function() {
        var formData = common.getForm("#user-add-form");

        var checkRes = check(formData);
        if(checkRes) {
            return dialog.error(checkRes);
        }

        $.post(common.adminAdd,formData,function(result) {
            if(result["status"] == 1) {
                return dialog.confirm(result["message"],1,"转到用户列表","继续添加",function() {
                    window.location.href = common.adminIndex;
                },function() {
                    window.location.href = common.adminAdd;
                })
            }
            if(result["status"] == 0) {
                return dialog.error(result["message"]);
            }
        },"json");

    });

    // 开启/关闭用户状态
    $(".user-list-table #user-on-off").click(function() {
        var id = $(this).attr("attr-id");
        var status = $(this).attr("attr-status");
        var message = "";
        var data = {};

        if(id) {
            if(status == 0) {
                message = "是否要开启用户？";
                data = {"id" : id,"status" : 1};
            }
            if(status == 1) {
                message = "是否要关闭用户？";
                data = {"id" : id,"status" : 0};
            }

            dialog.confirm(message,3,"确定","取消",function() {
                $.post(common.adminUpdate,data,function(result) {
                    if(result["status"] == 1) {
                        return dialog.success(result["message"],result["url"]);
                    }
                    if(result["status"] == 0) {
                        return dialog.error(result["message"]);
                    }
                },"json");
            },function() {})
        } else {
            return dialog.error("数据异常！");
        }
    });

    // 删除用户
    $(".user-list-table #user-delete").click(function() {
        var id = $(this).attr("attr-id");
        var status = -1;
        var data = {"id" : id,"status" : status};

        if(id) {
            dialog.confirm("是否删除用户？",3,"确定","取消",function() {
                $.post(common.adminUpdate,data,function(result) {
                    if(result["status"] == 1) {
                        return dialog.success(result["message"],result["url"]);
                    }
                    if(result["status"] == 0) {
                        return dialog.error(result["message"]);
                    }
                },"json");
            },function() {});
        } else {
            return dialog.error("数据不合法！");
        }
    });

    /**
     * 更新用户
     */
    $("#user-personal-save").click(function() {
        var formData = common.getForm("#user-personal-form");

        if(!formData['realname']) {
            return dialog.error("真实姓名不能为空！");
        }
        if(!formData['email']) {
            return dialog.error("email不能为空");
        }

        $.post(common.personal,formData,function(result) {
            if(result["status"] == 1) {
                return dialog.success(result["message"],common.personal);
            }
            if(result["status"] == 0) {
                return dialog.error(result["message"]);
            }
        },"json");
    });