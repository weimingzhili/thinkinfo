/*
 * 图片上传
 */

    $(function() {
        $("#thumb-upload").uploadify({
            swf : common.uploadSwf,                     // flash文件url
            uploader : common.thumbUpload,              // 服务器端处理脚本url
            buttonText : "选择图片",                     // 上传图片按钮提示信息
            fileTypeExts : "*.gif;*.jpg;*.jpeg;*.png",  // 允许上传的文件后缀
            fileTypeDesc : "Image Files",               // 文件上传框下拉列表描述
            fileSizeLimit : "1MB",                      // 限制上传文件的大小
            fileObjName : "imgFile",                     // 文件上传对象名

            // 当文件上传成功时
            onUploadSuccess : function(imgFile,data,response) {
                // 如果服务器端有输出
                if(response) {
                    var dataObj = $.parseJSON(data);    //将服务器端返回的字符串转成对象

                    $("#" + imgFile.id).find(".data").html(" 上传完毕"); // 图片上传完成的提示信息
                    $("#thumb-Img").attr("src",dataObj.url);       // 给图片设置路径
                    $("#thumb-Img").show();     // 显示上传的图片
                    $("#thumb").attr("value",dataObj.url); // 将图片上传后的路径赋值到隐藏按钮中
                } else {
                    alert("上传失败");
                }
            }
        });
    });