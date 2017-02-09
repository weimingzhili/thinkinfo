/*
    异步加载文章阅读数
 */
    var article_ids = [];
    $(".article-count").each(function(i) {
        article_ids[i] = $(this).attr("attr-id");
    });

    var articleIdStr = article_ids.join();
    var data = {"articleIdStr" : articleIdStr};

    $.post(common.indexCount,data,function(result) {
        if(result["status"] == 1) {
            var counts = result["data"];
            $.each(counts,function(article_id,count) {
                $(".node-"+article_id).html("阅读数（"+count+"）");
            });
        }
    },"json");