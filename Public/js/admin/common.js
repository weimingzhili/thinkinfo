/*
 后台通用
 */

    var common = {
        indexUrl : '/Admin/Index/index',      // 后台首页url
        loginCheckUrl : '/Admin/Login/check',    // 登录验证url

        // 菜单url
        listorderUrl : '/Admin/Menu/listOrder',     // 排序url
        menuListIndex : '/Admin/Menu/index',    // 菜单列表首页
        menuAddUrl : '/Admin/Menu/add',     // 添加添加
        menuEditUrl : '/Admin/Menu/edit',      // 编辑菜单
        menuUpdateStatus : "/Admin/Menu/updateStatus",      // 更新菜单状态

        // 文章url
        articleIndex : "/Admin/Article/index",
        articleList : "/Admin/Article/listOrder",
        articleAdd : "/Admin/Article/add",
        thumbUpload : "/Admin/Upload/imageUpload",
        articleEdit : "/Admin/Article/edit",
        articleUpdate : "/Admin/Article/update",
        articlePush : "/Admin/Article/push",

        // 推荐位url
        positionIndex : "/Admin/Position/index",
        positionAdd : "/Admin/Position/add",
        positionSave : "/Admin/Position/save",
        positionUpdate : "/Admin/Position/update",

        // 推荐位内容url
        positionContentIndex : "/Admin/PositionContent/index",
        positionContentOrder : "/Admin/PositionContent/order",
        positionContentAdd : "/Admin/PositionContent/add",
        positionContentEdit : "/Admin/PositionContent/edit",
        positionContentUpdate : "/Admin/PositionContent/update",

        // 用户管理
        adminIndex : "/Admin/Admin/index",
        adminAdd : "/Admin/Admin/add",
        adminUpdate : "/Admin/Admin/update",
        personal : "/Admin/Admin/personal",

        // 基本配置
        basicIndex : "/Admin/Basic/index",
        basicSave : "/Admin/Basic/save",
        basicCache : "/Admin/Basic/cache",

        // 其它
        uploadSwf : "/Public/plugins/uploadify/uploadify.swf",
        cacheIndex : "/Home/Index/buildIndexHtml",
        indexCount : "/Home/Index/getCount",


        // 获取表单数据
        getForm : function(formName) {
            var formObjArr = $(formName).serializeArray();
            var formArrData = {};
            $(formObjArr).each(function (i) {
                formArrData[this.name] = this.value;
            });

            return formArrData;
        }

    };