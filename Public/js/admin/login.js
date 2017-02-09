/*
 后台登录
 */

    $("#login-button").click(function() {
        var username = $("input[name=username]").val();     // 获取username
        var password = $("input[name=password]").val();     // 获取password
        var data = {"username":username,"password":password};       //将username和password打包

        if(!username) {     // 检查用户名是否为空
            dialog.error("用户名不能为空");
            return "";
        }
        if(!password) {     // 检查密码是否为空
            dialog.error("密码不能为空");
            return "";
        }

        // 将数据发送给服务器端，并接受处理服务器端返回的数据
        $.post(common.loginCheckUrl,data,function(result) {
            if(result['status'] == 0) {
                dialog.error(result['message']);
            }
            if(result['status'] == 1) {
                dialog.success(result['message'],common.indexUrl)
            }
        },"json");
    });