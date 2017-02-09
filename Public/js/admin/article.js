/*
 * 文章管理
 */

    // 文章排序
    $("#article-list").click(function() {
        var formData = common.getForm("#article-list-form");

        $.post(common.articleList,formData,function(result) {
            if(result["status"] == 0) {
                dialog.error(result["message"]);
            }
            if(result["status"] == 1) {
                dialog.confirm("操作成功！",1,"转到列表首页","留在当前页面",function() {
                    window.location.href = common.articleIndex;
                },function() {
                    window.location.href = result["url"];
                });
            }
        },"JSON");
    });

    // 跳转到文章添加页面
    $("#article-add").click(function() {
        window.location.href = common.articleAdd;
    });

    // KindEditor文本编辑器图片上传
    KindEditor.ready(function (K) {
        window.editor = K.create("#KindEditor",{
            uploadJson : common.thumbUpload,
            afterBlur : function() {this.sync();}    // 获取编辑器里的文字内容
        });
    });

    // 文章添加
    $("#article-add-submit").click(function() {
        var formData = common.getForm("#article-add-form");
        console.log(formData);

        var checkRes = articleCheck(formData);
        if(checkRes) {
            dialog.error(checkRes);
        } else {
            $.post(common.articleAdd,formData,function(result) {
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                if(result["status"] == 1) {
                    dialog.confirm("添加成功！",1,"转到列表","继续添加",function() {
                        window.location.href = common.articleIndex;
                    },function() {
                        window.location.href = common.articleAdd;
                    })
                }
            },"JSON");
        }
    });

    // 检查文章数据
    function articleCheck(formData) {
        if(!formData["title"]) {
            return "标题不能为空";
        }
        if(!formData["small_title"]) {
            return "短标题不能为空";
        }
        if(!formData["cat_id"]) {
            return "栏目不能为空";
        }
        if(!formData["content"]) {
            return "文章内容不能为空";
        }
        if(!formData["keywords"]) {
            return "关键词不能为空";
        }

        return false;
    }

    // 更新文章
    $("#article-edit-submit").click(function() {
        var formData = common.getForm("#article-edit-form");

        var checkRes = articleCheck(formData);
        if(checkRes) {
            dialog.error(checkRes);
        } else {
            $.post(common.articleEdit,formData,function(result) {
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                if(result["status"] == 1) {
                    dialog.success(result["message"],common.articleIndex);
                }
            },"JSON");
        }
    });

    // 更改文章状态
    $(".article-table #article-up-down").click(function() {
        var id = $(this).attr("attr-id");
        var oldStatus = $(this).attr("attr-status");
        var newStatus = "";
        var message = "";
        if(oldStatus == 1) {
            message = "是否关闭当前文章？";
            newStatus = 0;
        }
        if(oldStatus == 0) {
            message = "是否开启当前文章？";
            newStatus = 1;
        }

        dialog.confirm(message,3,"确定","取消",function() {
            var data = {};
            data['id'] = id;
            data['status'] = newStatus;

            $.post(common.articleUpdate,data,function(result) {
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                if(result["status"] == 1) {
                    dialog.success(result["message"],result["url"]);
                }
            },"JSON");
        },function() {})
    });

    // 删除文章
    $(".article-table #article-delete").click(function() {
        var id = $(this).attr("attr-id");
        if(id) {
            var status = -1;
            var data = {};
            data["id"] = id;
            data["status"] = status;

            dialog.confirm("是否确定删除文章？",3,"确定","取消",function() {
                $.post(common.articleUpdate,data,function(result) {
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                    if(result["status"] == 1) {
                        dialog.success(result["message"],result["url"]);
                    }
                },"JSON");
            },function() {})
        } else {
            dialog.error("数据异常！");
        }
    });

    // 文章推送
    $("#article-push").click(function() {
        var pos_id = $("#pos_id").val();
        var article_id = [];
        $("input[name='push-article']:checked").each(function(i) {
            article_id[i] = $(this).val();
        });

        var articleIdStr = article_id.join();

        if(pos_id != "null" && article_id) {
            dialog.confirm("是否确定推送文章？",3,"确定","取消",function() {
                var data = {"pos_id":pos_id,"articleIdStr":articleIdStr};
                $.post(common.articlePush,data,function(result) {
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                    if(result["status"] == 1) {
                        dialog.confirm("推送成功！",1,"转到推荐位内容页面","继续推送",function() {
                            window.location.href = common.positionContentIndex;
                        },function() {
                            window.location.href = result["url"];
                        })
                    }
                },"json");
            },function() {})
        } else {
            if(pos_id == "null") {
                dialog.error("请选择推荐位！");
            }
            if(!article_id) {
                dialog.error("请选择要推送的文章！");
            }

        }
    });