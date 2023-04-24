<?php
    $keywords = $_GET['keywords'];  //关键词
    $keywords_type = $_GET['keywords_type'];  //关键词类型

?>
<!DOCTYPE html>
<html>

<head>
    <title>图书借阅搜索</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link rel="stylesheet" type="text/css" href="../../skin/css/layui.min.css" />
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        .have{
            color: #009688;
        }
        .use{
            color: #ff5722;
        }
    </style>
</head>
	<body>
        <div>
            <table class="layui-hide" id="dataList" lay-filter="tab"></table>
            <script type="text/html" id="barDemo">
                <a class='layui-btn layui-btn-xs' lay-event='do'>借阅</a>
            </script>
            <script type="text/html" id="img"> <img src="{{d.book_cover}}" width="32" height="32" alt=""> </script>
            <script type="text/html" id="status">
                <p class="{{d.status == 0 ? 'have' : 'use'}}">{{d.status == 0 ? '在库' : '已借出'}}</p>
            </script>
        </div>
        <script src="../../skin/js/layui.min.js"></script>
        <script>
            layui.use(['table', 'layer'], function() {
                let $ = layui.jquery
                    ,table = layui.table
                    ,layer = layui.layer;

                // 创建渲染实例
                table.render({
                    elem: '#dataList',
                    type: 'POST',
                    url: '../../controllers/books_circulation/search_book.php?keywords=<?php echo $keywords; ?>&keywords_type=<?php echo $keywords_type; ?>',
                    parseData: function(res) { //res 即为原始返回的数据
                        // console.log(res); //打印数据显示
                        return {
                            "code": res.code, //解析接口状态
                            "msg": res.msg, //解析提示文本
                            "count": res.count, //解析数据长度
                            "data": res.data, //解析数据列表
                        }
                    },
                    response: {
                        statusCode: 200, //规定成功的状态码，默认：0
                    },
                    height: 'full-5', // 最大高度减去其他容器已占有的高度差
                    cellMinWidth: 100,
                    page: false, //开启分页
                    even: true, //隔行换色
                    loading: true,
                    text: {
                        none: '暂无数据'
                    },
                    cols: [
                        [{
                            field: 'book_id',
                            fixed: true,
                            width: 105,
                            title: '图书编号',
                            sort: true,
                            align: 'center'
                        },{
                            field: 'ISBN',
                            width: 180,
                            title: 'ISBN',
                            align: 'center'
                        },{
                            field: 'book_name',
                            width: 270,
                            title: '图书名称',
                            align: 'center'
                        }, {
                            field: 'author',
                            width: 140,
                            align: 'center',
                            title: '作者'
                        }, {
                            field: 'publisher',
                            width: 150,
                            title: '出版社',
                            align: 'center'
                        }, {
                            field: 'price',
                            title: '价格(元)',
                            width: 90,
                            align: 'center'
                        }, {
                            field: 'number',
                            title: '库存(本)',
                            width: 90,
                            align: 'center'
                        }, {
                            field: 'book_cover',
                            title: '图书封面',
                            width: 100,
                            align: 'center',
                            templet: '#img'
                        }, {
                            field: 'mark',
                            width: 170,
                            title: '图书简介',
                            minWidth: 320,
                            align: 'left',
                        }, {
                            field: 'save_position',
                            width: 190,
                            title: '藏书位置',
                            align: 'center',
                        }, {
                            field: 'status',  //借阅状态判断 0 在库 1 借出
                            width: 120,
                            title: '图书状态',
                            align: 'center',
                            templet: '#status'
                        }, {
                            field: 'borrow_num',
                            width: 120,
                            title: '借阅次数',
                            align: 'center',
                        }, {
                            fixed: 'right',
                            title: '操作',
                            width: 120,
                            align: 'center',
                            toolbar: '#barDemo'
                        }]
                    ],
                    done: function (res, curr, count){
                        // console.log(res);
                        hoverOpenImg();//显示大图

                    },
                    error: function(res, msg) {
                        console.log(res, msg)
                    }
                });

                //触发单元格工具事件
                table.on('tool(tab)', function(obj) {
                    let data = obj.data;
                    // console.log(data);
                    if (obj.event === 'do') {
                        $.ajax({
                            type: 'POST',
                            url: '../../controllers/books_circulation/do_borrow.php',
                            data: JSON.stringify(data),
                            dataType: 'json',
                            success: function (res){
                                // console.log(res);
                                //获取当前iframe层的索引
                                let index = parent.layer.getFrameIndex(window.name);
                                if(res.code === 200){
                                    layer.msg(res.msg, {
                                        time: 3000,
                                        shade: .2,
                                        icon: 6
                                    }, function (){
                                        // parent.layui.table.reload('dataList'); //刷新父级窗口的table数据
                                        parent.location.reload();  //直接刷新页面
                                        //关闭当前的iframe窗口
                                        parent.layer.close(index);
                                    })
                                }else{
                                    layer.msg(res.msg, {
                                        time: 3000,
                                        shade: .2,
                                        icon: 7
                                    }, function (){
                                        //关闭当前的iframe窗口
                                        parent.layer.close(index);
                                    });
                                }
                            }
                        })
                    }
                })

                //大图显示封面
                function hoverOpenImg(){
                    let img_show = null; // tips提示
                    $('td img').hover(function(){
                        //alert($(this).attr('src'));
                        let img = "<img src='"+$(this).attr('src')+"' style='width:130px;' />";
                        img_show = layer.tips(img, this,{
                            tips:[2, 'rgba(41,41,41,.3)']
                            ,area: ['160px']
                        });
                    },function(){
                        layer.close(img_show);
                    });
                    $('td img').attr('style','max-width: 100px');
                }
            })
        </script>
    </body>
</html>



