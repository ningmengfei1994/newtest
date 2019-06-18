// 1.配置模块
// require.config({});

require.config({
    // 1.1声明模块
    // 一共声明的模块有：jquery，模块引擎，分页插件，bootstrap
    paths: { //作用是：声明每个模块的名称和每个模块对应的路径

        // 模块的名字：模块对应的js路径-注意路径是不带后缀名
        "jquery": "/static/assets/vendors/jquery/jquery",
        "template": "/static/assets/vendors/art-template/template-web",
        "pagination": "/static/assets/vendors/twbs-pagination/jquery.twbsPagination",
        "bootstrap": "/static/assets/vendors/bootstrap/js/bootstrap"

    },

    // 声明多个模块之前的依赖关系，比如分页插件是依赖于jquery的，bootstrap也是依赖于jquery的
    // 1.2声明模块和模块之间以来的关系
    shim: {
        // 模块名字
        "pagination": {
            //deos声明模块是以来哪些模块的
            deps: ["jquery"] //因为依赖的模块可能有很多个，以数组方式表示

        },
        "botstrap": {
            deps: ["jquery"]
        }

    }

});

// 回调
require(["jquery", "template", "pagination", "bootstrap"], function($, template, pagination, bootstrap) {
    $(function() {
        //  定当前页码和每页个数
        // 当前所在页码
        var currentPage = 1;
        // 每页内容条数
        var pageSize = 10;
        getCommentsData();

        // 发送请求
        function getCommentsData() {
            $.ajax({
                type: "post",
                url: "api/_getComments.php",
                data: { currentPage: currentPage, pageSize: pageSize },
                dataType: "json",
                success: function(response) {
                    if (response.code == 1) {

                        // 使用模快引擎生成结构
                        // 导入模块数据 

                        var html = template("commentTemp", response);
                        $("tbody").html(html);


                        // 分页插件写在成功输出语句下边成功后才输出
                        $('.pagination').twbsPagination({
                            totalPages: response.pageCount, //最大页码数
                            visiblePages: 7, //显示几个分页按钮
                            // 点击分页按钮的操作
                            // 第一个参数是事件对象，第二个参数是当前页码数
                            onPageClick: function(event, page) {
                                currentPage = page;
                                // 每次点击分页按钮也要获取数据
                                getCommentsData();
                            }
                        })

                    }
                }
            });
        }


    })
})