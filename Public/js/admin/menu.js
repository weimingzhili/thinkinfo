/*
 菜单管理
 */

    // 菜单排序
    $("#menu-list").click(function() {
        // 获取表单数据
        $formData = common.getForm("#singcms-listorder");

        // 把表单数据发送到服务器端
        $.post(common.listorderUrl,$formData,function(result) {
            if(result["status"] == 0) {
                dialog.error(result["message"]);
            }
            if(result["status"] == 1) {
                dialog.confirm("菜单排序成功",1,"转到列表首页","留在当前页面",function() {
                    window.location.href = common.menuListIndex;
                },function() {
                    window.location.href = result["url"];
                });
            }
        },"JSON");
    });

    // 跳转到菜单添加页面
    $("#button-add").click(function() {
        window.location.href = common.menuAddUrl;
    });

    // 检查菜单数据
    function checkMenu(data) {
        if(!data['name']) {
            return "菜单名不能为空";
        }
        if(!data['m']){
            return "模块名不能为空";
        }
        if(!data['c']){
            return "控制器不能为空";
        }
        if(!data['f']){
            return "方法不能为空";
        }

        return false;
    }

    // 添加菜单
    $("#singcms-button-submit").click(function() {
        // 获取表单数据
        var formData = common.getForm("#singcms-form");

        // 检查表单数据
        var checkRes = checkMenu(formData);
        if(checkRes) {
            dialog.error(checkRes);
        } else {
            // 发送表单数据并对返回的结果进行处理
            $.post(common.menuAddUrl,formData,function(result) {
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                if(result["status"] == 1) {
                    dialog.confirm("菜单添加成功",1,"转到列表首页","继续添加",function() {
                        window.location.href = common.menuListIndex;
                    },function() {
                        window.location.href = common.menuAddUrl;
                    });
                }
            },"JSON");
        }

    });

    // 编辑菜单
    $("#menu-edit").click(function() {
        // 获取表单数据
        var formData = common.getForm("#singcms-form");

        // 检查表单数据
        var checkRes = checkMenu(formData);
        if(checkRes) {
            dialog.error(checkRes);
        } else {
            // 发送表单数据并对返回的结果进行处理
            $.post(common.menuEditUrl,formData,function(result) {
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
                if(result["status"] == 1) {
                    dialog.success(result["message"],common.menuListIndex);
                }
            },"JSON");
        }

    });

    // 更新菜单状态
    function updateMenu(btnName,attrName,status,title,url) {
        $(btnName).click(function() {
            var id = $(this).attr(attrName);
            var menuData = {};
            menuData["menu_id"] = id;
            menuData["status"] = status;

            dialog.confirm(title,3,"确定","取消",function() {
                $.post(url,menuData,function(result) {
                    if(result["status"] == 0) {
                        dialog.error(result["message"]);
                    }
                    if(result["status"] == 1) {
                        dialog.success(result["message"],result["url"]);
                    }
                });
            },function() {});

        });
    }

    // 关闭菜单
    updateMenu(".singcms-table #menu-close","attr-id",0,"是否要关闭当前菜单？",common.menuUpdateStatus);

    // 开启菜单
    updateMenu(".singcms-table #menu-up","attr-id",1,"是否要开启当前菜单？",common.menuUpdateStatus);

    // 删除菜单
    updateMenu(".singcms-table #singcms-delete","attr-id",-1,"是否要删除当前菜单？",common.menuUpdateStatus);