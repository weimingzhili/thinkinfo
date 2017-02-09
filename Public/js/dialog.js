/**
 * 后台弹出层类
 */

    var dialog = {
        // 成功弹出层
        success : function(message,url) {
            layer.msg(message, {
                    icon: 1,
                    time : 1000
                }, function (){
                window.location.href = url;
            });
        },

        // 错误弹出层
        error : function(message) {
            layer.open({
                content : message,
                icon : 2,
                title : '错误提示'
            });
        },

        // 询问提示框
        confirm : function(message,icon,btn1Msg,btn2Msg,btn1Func,btn2Func) {
            layer.confirm(message,{
                icon : icon,
                btn : [btn1Msg,btn2Msg]
            },btn1Func,btn2Func);
        },

        // tip
        tips : function() {
            layer.tips()
        }
    };