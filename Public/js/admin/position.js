// 推荐位相关js

    // 跳转到添加页面
    $("#position-list-add").click(function() {
        window.location.href = common.positionAdd;
    });

    // 添加推荐位
    $("#position-add-submit").click(function() {
        // 获取表单数据
        var formData = common.getForm("#position-add-form");

        // 检查数据
        if(!formData['pos_name']) {
            dialog.error("请填写推荐位名称！");
        } else {
            // 发送数据
            $.post(common.positionAdd,formData,function(result) {
                // 添加失败
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                // 添加成功
                if(result["status"] == 1) {
                    dialog.confirm(result["message"],1,"转到列表首页","继续添加",function() {
                        window.location.href = common.positionIndex;
                    },function() {
                        window.location.href = common.positionAdd;
                    })
                }
            },"json");
        }
    });

    // 保存推荐位
    $("#position-edit-save").click(function() {
        var formData = common.getForm("#position-edit-form");

        if(!formData["pos_name"]) {
            dialog.error("请填写推荐位名称！");
        } else {
            $.post(common.positionSave,formData,function(result) {
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                if(result["status"] == 1) {
                    dialog.success(result["message"],common.positionIndex);
                }
            },"json");
        }
    });

    // 开启/关闭推荐位
    $(".position-list-table #position-on-off").click(function() {
        var id = $(this).attr("attr-id");
        var status = $(this).attr("attr-status");

        if(id) {
            var message = "";
            var data = {'pos_id':id};

            if(status == 0) {
                message = "是否开启推荐位？";
                data["status"] = 1;
            }
            if(status == 1) {
                message = "是否关闭推荐位？";
                data["status"] = 0;
            }

            dialog.confirm(message,3,"确定","取消",function() {
                $.post(common.positionUpdate,data,function(result) {
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                    if(result["status"] == 1) {
                        dialog.success(result["message"],result["url"]);
                    }
                },"json");
            },function() {})

        } else {
            dialog.error("数据异常！");
        }
    });

    // 删除推荐位
    $(".position-list-table #position-delete").click(function() {
        var id = $(this).attr("attr-id");

        if(id) {
            var data = {"pos_id":id,"status":-1};
            dialog.confirm("是否删除推荐位？",3,"确定","取消",function() {
                $.post(common.positionUpdate,data,function(result) {
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                    if(result["status"] == 1) {
                        dialog.success(result["message"],result["url"]);
                    }
                },"json");
            },function() {});
        } else {
            dialog.error("数据异常！");
        }
    });
