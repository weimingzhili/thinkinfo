/*
 推荐位内容操作
 */

    // 推荐位内容排序
    $("#position-content-list").click(function() {
        var formData = common.getForm("#position-content-list-form");
        var data = {'listData':formData};

        $.post(common.positionContentOrder,data,function(result) {
            if(result["status"] == 0) {
                dialog.error(result["message"]);
            }
            if(result["status"] == 1) {
                dialog.confirm("排序成功！",1,"转到列表首页","留在当前页面",function() {
                    window.location.href = common.positionContentIndex;
                },function() {
                    window.location.href = result["url"];
                })
            }
        },"json");
    });

    // 跳转到添加页面
    $("#position-content-list-add").click(function() {
        window.location.href = common.positionContentAdd;
    });

    // 检查推荐位内容数据
    function positionContentCheck(data) {
        if(!data["title"]) {
            return "请填写文章标题！";
        }
        if(data["pos_id"] == "null") {
            return "请选择推荐位！";
        }
        if(!data["thumb"] && !data["article_id"]) {
            return "封面图和文章id不能同时为空！";
        }
        if(!data["url"] && !data["article_id"]) {
            return "url和文章id不能同时为空！";
        }

        return false;
    }

    // 添加推荐位内容
    $("#position-content-add-submit").click(function() {
        var formData = common.getForm("#position-content-add-form");

        var checkRes = positionContentCheck(formData);
        if(checkRes) {
            dialog.error(checkRes);
        } else {
            $.post(common.positionContentAdd,formData,function(result) {
                if(result["status"] == 1) {
                    dialog.confirm(result["message"],1,"转到列表首页","继续添加",function() {
                        window.location.href = common.positionContentIndex;
                    },function() {
                        window.location.href = common.positionContentAdd;
                    });
                }
            },"json");
        }
    });

    // 保存推荐位内容
    $("#position-content-save").click(function() {
        var formData = common.getForm("#position-content-edit-form");

        var checkRes = positionContentCheck(formData);
        if(checkRes) {
            dialog.error(checkRes);
        } else {
            $.post(common.positionContentEdit,formData,function(result) {
                if(result["status"] == 1) {
                    dialog.success(result["message"],common.positionContentIndex);
                }
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
            },"json");
        }
    });

    // 开启/关闭推荐位内容
    $(".position-content-table #position-content-on-off").click(function() {
        var posc_id = $(this).attr("attr-id");
        var status = $(this).attr("attr-status");
        var message = "";
        var data = {};

        if(posc_id) {
            if(status == 0) {
                message = "是否开启推荐位内容？";
                data = {"posc_id":posc_id,"status":1};
            }
            if(status == 1) {
                message = "是否关闭推荐位内容？";
                data = {"posc_id":posc_id,"status":0};
            }

            dialog.confirm(message,3,"确定","取消",function() {
                $.post(common.positionContentUpdate,data, function (result) {
                    if(result["status"] == 1) {
                        dialog.success(result["message"],result["url"]);
                    }
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                },"json");
            },function() {})
        } else {
            dialog.error("数据异常！");
        }
    });

    // 删除推荐位内容
    $(".position-content-table #position-content-delete").click(function() {
        var posc_id = $(this).attr("attr-id");
        var data = {"posc_id":posc_id,"status":-1};

        if(posc_id) {
            dialog.confirm("是否删除推荐位内容？",3,"确定","取消",function() {
                $.post(common.positionContentUpdate,data,function(result) {
                    if(result["status"] == 1) {
                        dialog.success(result["message"],result["url"]);
                    }
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                },"json");
            },function() {});
        } else {
            dialog.error("数据异常！");
        }
    });