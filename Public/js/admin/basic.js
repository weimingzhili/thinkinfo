/*
    基本配置操作
 */

    // 检查配置
    function configCheck(data) {
        if(!data['title']) {
            return "站点标题不能为空！";
        }
        if(!data['keywords']) {
            return "站点关键词不能为空！";
        }
        if(!data['description']) {
            return "站点描述不能为空！";
        }

        return false;
    }

    // 保存配置
    $("#basic-config-save").click(function() {
        var formData = common.getForm("#basic-config-form");

        var checkRes = configCheck(formData);
        if(checkRes) {
            dialog.error(checkRes)
        } else {
            $.post(common.basicSave,formData,function(result) {
                if(result["status"] == 1) {
                    dialog.success(result["message"],common.basicIndex);
                }
                if(result["status"] == 0) {
                    dialog.error(result["message"]);
                }
            },"json");
        }
    });

    // 首页静态化
    $("#cache-index").click(function() {
        var user = $("#user").val();
        var data = {'user':user};

        $.post(common.cacheIndex,data,function(result) {
            if(result["status"] == 1) {
                return dialog.success(result["message"],common.basicCache);
            }
            if(result["status"] == 0) {
                return dialog.error(result["message"]);
            }
        },"json");
    });