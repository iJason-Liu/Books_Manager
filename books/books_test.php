<?php
session_save_path('../session/');
session_start();
include '../config/conn.php';
if ($_SESSION['is_flag'] != 2) {
    echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
}
// 设置文档类型：，utf-8支持中文文档
header("Content-Type:text/html;charset=utf-8");

//执行sql语句的查询语句
$sql1 = "select * from book_list";
$result = mysqli_query($db_connect, $sql1);

mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>表格数据</title>
    <link rel="shortcut icon" href="../images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/layui.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/modules/layer/layer.css">
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
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <a href="../administrator/index.php">
                <div class="layui-logo layui-hide-xs layui-bg-black">Library</div>
            </a>
            <!-- 头部区域（可配合layui 已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <!-- 移动端显示 -->
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
                    <i class="layui-icon layui-icon-spread-left"></i>
                </li>

                <li class="layui-nav-item layui-hide-xs"><a href="../administrator/index.php">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../index.php?user=<?php echo $_SESSION['user'] ?>">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="">帮助中心</a></li>
                <!-- <li class="layui-nav-item">
                    <a href="javascript:;">更多</a>
                    <dl class="layui-nav-child">
                        <dd><a href="">menu 11</a></dd>
                        <dd><a href="">menu 22</a></dd>
                        <dd><a href="">menu 33</a></dd>
                    </dl>
                </li> -->
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item layui-hide layui-show-md-inline-block">
                    <a href="javascript:;">
                        <img src="../images/avatar.png" class="layui-nav-img">
                        <?php
                        if ($_SESSION['is_flag'] != 2) {
                            echo "<script>alert('您没有权限访问！');location.href='../login/login.php'</script>";
                        } else {
                            echo "您好！". $_SESSION['user'];
                        }
                        ?>
                    </a>
                    <dl class="layui-nav-child layui-nav-child-c">
                        <!-- <dd><a href="#" style="font-size:14px;">
                            身份：
                        </a></dd> -->
                        <dd><a href="../info/myInfo.php">个人中心</a></dd>
                        <dd><a href="../info/update_info.php">修改密码</a></dd>
                        <dd><a href="../login/logout.php">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item">
                        <a class="" href="javascript:;">个人中心</a>
                        <dl class="layui-nav-child">
                            <!-- 包含注销功能，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <dd><a href="../info/myInfo.php">信息管理</a></dd>
                            <dd><a href="../info/update_info.php">修改密码</a></dd>
                        </dl>
                    </li>

                    <!-- 判断身份为超级管理员时显示 -->
<!--                    <li class="layui-nav-item">-->
<!--                        <a class="" href="javascript:;">馆员中心</a>-->
<!--                        <dl class="layui-nav-child">-->
<!--                            <dd><a href="javascript:;">馆员档案</a></dd>-->
<!--                        </dl>-->
<!--                    </li>-->

                    <!-- 根据权限判断是否显示(学生教师不显示) -->
<!--                    <li class="layui-nav-item">-->
<!--                        <a href="javascript:;">读者中心</a>-->
<!--                        <dl class="layui-nav-child">-->
<!--                            <dd><a href="javascript:;">读者档案</a></dd>-->
<!--                            <dd><a href="javascript:;">读者类型</a></dd>-->
<!--                        </dl>-->
<!--                    </li>-->

                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;">图书管理 </a>
                        <dl class="layui-nav-child">
                            <!-- 图书查询包含编号、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd class="layui-this"><a href="../books/books_test.php">馆藏图书</a></dd>
                            <!-- 包含查询，书库名，编号，位置 -->
                            <dd><a href="../upload/test.php">书库信息</a></dd>
                            <!-- 图书点击量 -->
                            <dd><a href="../books/books_list.php">人气图书</a></dd>
                            <dd><a href="javascript:;">图书类别</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">流通管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../books_usage/borrow_stau.php">图书借阅查询</a></dd>
                            <dd><a href="javascript:;">图书续借</a></dd>
                            <dd><a href="javascript:;">图书归还</a></dd>
                        </dl>
                    </li>

                    <!-- 评论只允许管理员和超级管理员查看 -->
<!--                    <li class="layui-nav-item">-->
<!--                        <a href="javascript:;">评论管理</a>-->
<!--                        <dl class="layui-nav-child">-->
<!--                            <dd><a href="javascript:;">评论中心</a></dd>-->
<!--                            <dd><a href="javascript:;">评论风控</a></dd>-->
<!--                        </dl>-->
<!--                    </li>-->

                    <li class="layui-nav-item">
                        <a href="javascript:;">系统维护</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">权限管理</a></dd>
                            <dd><a href="javascript:;">系统信息</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="https://cupfox.app/" target="_blank">友情链接</a></li>
                    <li class="layui-nav-item"><a href="https://qinggongju.com/#tab-19-308" target="_blank">小工具</a></li>
                </ul>
            </div>
        </div>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <table class="layui-hide" id="bookcase" lay-filter="test"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-sm" lay-event="exportBook">添加图书</button>
                    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="multi-row">
                        多行显示
                    </button>
                    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row">
                        单行显示
                    </button>
                    <button class="layui-btn layui-btn-sm" lay-event="tip">tips</button>
                </div>
            </script>

            <script type="text/html" id="barDemo">
                <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>
            <script type="text/html" id="img"> <img src="{{d.book_cover}}" width="32" height="30" alt=""> </script>
            <script type="text/html" id="status">
                <p class="{{d.status == 0 ? 'have' : 'use'}}">{{d.status == 0 ? '在库' : '已借出'}}</p>
            </script>
            <div id="laypage" style="position: fixed;bottom: 42px;border-style: solid;border-color: #eee;z-index:999;width: 100%;background: #fff;"></div>
            <div id="test">
                <script>

                </script>
            </div>

            <?php
                //定义返回的数据头
                //$status = array('code' => 200,'msg' => "success");
//                $res = array('code' => 200,'msg' => "success",'count' => mysqli_num_rows($result),'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC));
                //把两串数据拼起来
                //$res = array_merge($status,$res);
//                $data = json_encode($res, JSON_UNESCAPED_UNICODE);
                // 把数据写入json文件
//                file_put_contents('../json/bookListFile.json',$data);
            ?>
            <script src="../js/layui.simple.js"></script>
            <script src="../js/jquery-3.3.1.min.js"></script>
                <script>
                    layui.use(['table','laypage'], function() {
                        let table = layui.table,
                        laypage = layui.laypage,
                        pageNo = 1,
                        limit = 5;

                        // 创建渲染实例
                        table.render({
                            elem: '#bookcase',
                            type: 'POST',
                            url: '../books/booksData.php',
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
                            where: { //接口参数，page为分页参数
                                page: pageNo
                            },
                            // page: !0 || { //详细参数可参考 laypage 组件文档
                            //     curr: 1,
                            //     layout: ['prev', 'page', 'next', 'skip', 'count', 'limit'] //自定义分页布局
                            // },
                            // even: true,
                            // limit: limit,
                            // limits: [5,10,15],
                            toolbar: '#toolbarDemo',
                            height: 'full-170', // 最大高度减去其他容器已占有的高度差
                            cellMinWidth: 100,
                            // totalRow: true, // 开启合计行
                            page: false, //开启分页
                            text: {
                                none: '暂无数据'
                            },
                            cols: [
                                [{
                                    type: 'checkbox',
                                    fixed: 'left'
                                }, {
                                    field: 'book_id',
                                    fixed: 'left',
                                    width: 110,
                                    title: '图书编号',
                                    sort: true,
                                    align: 'center'
                                }, {
                                    field: 'book_name',
                                    width: 200,
                                    title: '图书名称',
                                    align: 'center'
                                }, {
                                    field: 'author',
                                    width: 140,
                                    align: 'center',
                                    title: '作者'
                                }, {
                                    field: 'book_type',
                                    width: 100,
                                    title: '图书类别',
                                    align: 'center'
                                }, {
                                    field: 'publisher',
                                    width: 150,
                                    title: '出版社',
                                    align: 'center'
                                }, {
                                    field: 'price',
                                    title: '价格(元)',
                                    // hide: 0,
                                    width: 90,
                                    align: 'center',
                                    sort: true
                                },
                                //     {
                                //     field: 'number',
                                //     title: '库存',
                                //     width: 100,
                                //     sort: true,
                                //     align: 'center'
                                // },
                                    {
                                    field: 'book_cover',
                                    title: '图书封面',
                                    width: 100,
                                    align: 'center',
                                    templet: '#img'
                                }, {
                                    field: 'mark',
                                    width: 150,
                                    title: '图书简介（可编辑）',
                                    edit: 'textarea', //后续修改单独更新值到数据库中update book_list set mark='修改后的值' where id=''
                                    minWidth: 260,
                                    align: 'left',
                                    style: '-moz-box-align: start;'
                                }, {
                                    field: 'save_position',
                                    width: 140,
                                    title: '藏书位置',
                                    align: 'center',
                                    style: '-moz-box-align: start;'
                                }, {
                                    field: 'status',  //借阅状态判断 0 在库 1 借出
                                    width: 120,
                                    title: '借阅状态',
                                    align: 'center',
                                    style: '-moz-box-align: start;',
                                    templet: '#status'
                                }, {
                                    field: 'create_date',
                                    width: 175,
                                    title: '入库时间',
                                    align: 'center',
                                    style: '-moz-box-align: start;'
                                }, {
                                    field: 'update_date',
                                    width: 175,
                                    title: '更新时间',
                                    align: 'center',
                                    style: '-moz-box-align: start;'
                                }, {
                                    fixed: 'right',
                                    title: '操作',
                                    width: 160,
                                    minWidth: 170,
                                    align: 'center',
                                    toolbar: '#barDemo'
                                }
                                ]
                            ],
                            initSort:{   //按编号升序排序
                                field: 'book_id',
                                type: 'asc',
                            },
                            done: function (res, curr, count){
                                hoverOpenImg();//显示大图
                                // fillTable(res.data, (pageNo - 1) * limit); //页面
                                // console.log(res);
                                //在获取到表格数据后加载分页组件，点击分页时调用table的reload方法重新加载表格数据达到分页效果
                                laypage.render({
                                    elem: 'laypage', //分页容器ID
                                    count: res.count, //设置分页数据总数
                                    curr: pageNo, //当前页码
                                    limit: limit, //分页大小
                                    limits: [5,10,15,20],
                                    layout: ['prev', 'page', 'next', 'skip', 'count', 'limit'],
                                    jump: function (obj, first) {//跳转方法
                                        // console.log(obj);
                                        if (!first) {  //若不为第一页
                                            pageNo = obj.curr;//设置全局变量page 为当前选择页码
                                            limit = obj.limit;//设置全局变量limit 为当前选择分页大小
                                            table.reload('bookcase', {//重新加载表格
                                                where: { //接口参数，page为分页参数
                                                    page: pageNo
                                                }
                                            });
                                        }
                                    }
                                })
                            },
                            error: function(res, msg) {
                                console.log(res, msg)
                            }
                        });

                        // 工具栏事件
                        table.on('toolbar(test)', function(obj) {
                            let id = obj.config.id;
                            let checkStatus = table.checkStatus(id);
                            // 获取选中的数据
                            let data = checkStatus.data;
                            switch (obj.event) {
                                case 'exportBook':
                                    layer.open({
                                        title: '新增图书',
                                        type: 2,
                                        area: ['50%', '88%'],
                                        skin: 'layui-layer-molv',
                                        maxmin: true,
                                        shadeClose: true,
                                        content: '../books/add_books.php'
                                    });
                                    break;
                                case 'multi-row':
                                    table.reload('bookcase', {
                                        // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
                                        lineStyle: 'height: 120px;'
                                    });
                                    layer.msg('将显示更多的内容！');
                                    break;
                                case 'default-row':
                                    table.reload('bookcase', {
                                        lineStyle: null // 恢复单行
                                    });
                                    layer.msg('将显示更少的内容！');
                                    break;
                                case 'tip':
                                    layer.msg('表格可以左右滑动查看更多内容噢~');
                                    break;
                            };
                        });

                        //触发单元格工具事件
                        table.on('tool(test)', function(obj) { // 双击 toolDouble
                            let data = obj.data;
                            // console.log(data);
                            let id = data.book_id;
                            // 图书详情url
                            let url = '../books/books_detail.php?id='+id;
                            // 图书更新信息url
                            let url1 = '../books/update_books.php?id='+id;
                            // alert(url);
                            // console.log(obj);
                            if (obj.event === 'detail') {
                                layer.open({
                                    title: '图书详细信息',
                                    type: 2,
                                    area: ['50%', '88%'],
                                    content: url,
                                    skin: 'layui-layer-molv',
                                    maxmin: true,
                                    shadeClose: true,
                                });
                            } else if (obj.event === 'edit') {
                                layer.open({
                                    title: '编辑图书信息',
                                    type: 2,
                                    area: ['50%', '88%'],
                                    content: url1,
                                    // btn: ['确认','取消'],
                                    skin: 'layui-layer-molv',
                                    maxmin: true,
                                    shadeClose: true,
                                    // success: function (){
                                    //
                                    //     layer.close();
                                    // }
                                });
                            }else if(obj.event === 'del'){
                                layer.confirm('是否确认删除此书？', function() {
                                    layer.msg('已删除', {
                                        icon: 1,
                                        time: 2000
                                    });
                                    location.href = "../books/del_book.php?id="+id;
                                },function (){
                                    layer.msg('取消操作', {
                                        time: 1500, //1.5s后自动关闭
                                    });
                                });
                            }
                        });

                        //触发表格复选框选择
                        table.on('checkbox(test)', function(obj) {
                            // console.log(obj);
                        });

                        //触发表格单选框选择
                        table.on('radio(test)', function(obj) {
                            // console.log(obj)
                        });

                        // 行单击事件
                        table.on('row(test)', function(obj) {
                            //console.log(obj);
                            //layer.closeAll('tips');
                        });
                        // 行双击事件
                        table.on('rowDouble(test)', function(obj) {
                            // console.log(obj);
                        });

                        // 单元格编辑事件
                        table.on('edit(test)', function(obj) {
                            let field = obj.field, //得到字段
                                value = obj.value, //得到修改后的值
                                data = obj.data; //得到所在行所有键值
                            $.ajax({
                                type : "POST",
                                url : '../books/test.php',
                                data:{
                                    'id': data.book_id ,
                                    'mark': value
                                },
                                success : function(data) {
                                    console.log('success');
                                }
                            });

                            // let update = {};
                            // update[field] = value;
                            // obj.update(update);
                        });
                    });

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
                </script>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../images/beian.png">滇ICP备2023001154号-1</a>
            </p>
        </div>
    </div>
</body>
</html>