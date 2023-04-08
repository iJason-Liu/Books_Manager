<?php
    /*
     * 图书搜索
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    //执行sql语句的查询语句
//    $sql1 = "select * from book_list";
//    $result = mysqli_query($db_connect, $sql1);

    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $usertype = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select type_id from user_type where usertype_name='$usertype'";
    $res = mysqli_query($db_connect, $check_sql);

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>图书检索中心</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link href="../../skin/css/layui.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        /*隐藏功能*/
        .show {
            display: block !important;
        }

        .hide {
            display: none !important;
        }

        .have{
            color: #009688;
        }
        .use{
            color: #ff5722;
        }

        .layui-edge{
            right: 0;
        }
        .layui-select-title input{
            text-align: center;
            padding-left: 0;
            height: 45px;
        }
    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function () {
            // return false;
        }
        //禁用浏览器右键点击事件
        document.oncontextmenu = function () {
            return false;
        }
        //禁止拖拽
        document.ondragstart = function () {
            return false
        }
        //禁止用户选中网页上的内容
        // document.onselectstart=function(){return false}
        //禁用复制剪贴版
        document.onbeforecopy = function () {
            // return false
        }
        //禁用文本框或者文本域中的文字被选中
        // document.onselect=function(){return false;}
    </script>
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <a href="../index.php">
                <div class="layui-logo layui-bg-black">Library</div>
            </a>
            <!-- 头部区域（可配合layui 已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-hide-xs"><a href="../index.php">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../../index.php">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide.php">帮助中心<span class="layui-badge">1</span></a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item layui-hide-xs layui-show-md-inline-block">
                    <a href="javascript:;">
                        <img src="<?php echo $_SESSION['src'] ?>" class="layui-nav-img">
                        <?php
                            echo "您好！". $_SESSION['user'];
                        ?>
                    </a>
                    <dl class="layui-nav-child layui-nav-child-c">
                        <?php
                            if($usertype != '超级管理员'){
                                echo "<dd><a href='../user_center/user_Info.php'>个人中心</a></dd>";
                            }
                        ?>
                        <dd><a href="../user_center/update_pwd.php">修改密码</a></dd>
                        <dd><a href="../../login/logout.php">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <?php
        while ($row = mysqli_fetch_array($res)) {
            $type_id = $row['type_id'];
            ?>
            <div class="layui-side layui-bg-black">
                <div class="layui-side-scroll">
                    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                    <ul class="layui-nav layui-nav-tree" lay-filter="demo">
                        <li class="layui-nav-item">
                            <a class="" href="javascript:;"><i class="layui-icon layui-icon-username"></i>&nbsp;个人中心</a>
                            <dl class="layui-nav-child">
                                <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                                <?php
                                    if($type_id != 1004){
                                        echo "<dd><a href='../user_center/user_Info.php'><i class='layui-icon layui-icon-username'></i>&nbsp;我的信息</a></dd>";
                                    }
                                ?>
                                <dd><a href="../user_center/update_pwd.php"><i class="layui-icon layui-icon-password"></i>&nbsp;修改密码</a></dd>
                                <dd><a href="../user_center/account_del.php"><i class="layui-icon layui-icon-logout"></i>&nbsp;账号注销</a></dd>
                            </dl>
                        </li>

                        <!-- 判断身份为超级管理员时显示 -->
                        <li class="layui-nav-item
                        <?php
                            if ($type_id == 1004) {
                                echo "show";
                            } else {
                                echo "hide";
                            }
                        ?>">
                            <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>&nbsp;馆员中心</a>
                            <dl class="layui-nav-child">
                                <dd><a href="../lib_worker/worker_list.php"><i class="layui-icon layui-icon-group"></i>&nbsp;馆员档案</a></dd>
                            </dl>
                        </li>

                        <!-- 学生、教师不显示 -->
                        <li class="layui-nav-item
                        <?php
                            if ($type_id == 1003 || $type_id == 1004) {
                                echo "show";
                            } else {
                                echo "hide";
                            }
                        ?>">
                            <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>&nbsp;读者中心</a>
                            <dl class="layui-nav-child">
                                <dd><a href="../reader/reader_list.php"><i class="layui-icon layui-icon-group"></i>&nbsp;&nbsp;读者档案</a></dd>
                                <dd><a href="../reader/reader_kind.php"><i class="layui-icon layui-icon-cols"></i>&nbsp;&nbsp;读者类型</a></dd>
                            </dl>
                        </li>

                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="javascript:;"><i class="layui-icon layui-icon-read"></i>&nbsp;图书管理</a>
                            <dl class="layui-nav-child">
                                <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                                <dd><a href="../books_source/book_list.php"><i class="layui-icon layui-icon-read"></i>&nbsp;馆藏图书</a></dd>
                                <dd class="layui-this"><a href="../books_source/book_search.php"><i class="layui-icon layui-icon-search"></i>&nbsp;图书查询</a></dd>
                                <!-- 图书点击量，借阅次数 -->
                                <dd><a href="../books_source/rank_book.php"><i class="layui-icon layui-icon-praise"></i>&nbsp;人气图书</a></dd>
                                <?php
                                    if ($type_id == 1003 || $type_id == 1004) {
                                        echo "<dd><a href='../books_source/book_kind.php'><i class='layui-icon layui-icon-form'></i>&nbsp;图书类别</a></dd>";
                                    }
                                ?>
                                <!-- 包含查询，书库名，编号，位置 -->
                                <dd><a href="../books_source/book_stack.php"><i class="layui-icon layui-icon-diamond"></i>&nbsp;书库信息</a></dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a href="javascript:;"><i class="layui-icon layui-icon-template-1"></i>&nbsp;流通管理</a>
                            <dl class="layui-nav-child">
                                <dd><a href="../books_borrow/borrow_status.php"><i class="layui-icon layui-icon-release"></i>&nbsp;图书借阅</a></dd>
                                <!-- 续借操作，每次完成续借时间推迟7天  -->
                                <dd><a href="../books_borrow/renewBook.php"><i class="layui-icon layui-icon-refresh"></i>&nbsp;图书续借</a></dd>
                                <dd><a href="../books_borrow/returnBook.php"><i class="layui-icon layui-icon-prev-circle"></i>&nbsp;图书归还</a></dd>
                            </dl>
                        </li>

                        <!-- 评论只允许管理员和超级管理员查看 -->
                        <li class="layui-nav-item
                        <?php
                            if ($type_id == 1003 || $type_id == 1004) {
                                echo "show";
                            } else {
                                echo "hide";
                            }
                        ?>">
                            <a href="javascript:;"><i class="layui-icon layui-icon-dialogue"></i>&nbsp;评论管理</a>
                            <dl class="layui-nav-child">
                                <dd><a href="../comment/comment_center.php"><i class="layui-icon layui-icon-reply-fill"></i>&nbsp;评论中心</a></dd>
                                <dd><a href="../comment/comment_control.php"><i class="layui-icon layui-icon-set-fill"></i>&nbsp;评论风控</a></dd>
                            </dl>
                        </li>

                        <!-- 仅超级管理员显示权限管理 -->
                        <li class="layui-nav-item">
                            <a href="javascript:;"><i class="layui-icon layui-icon-console"></i>&nbsp;系统维护</a>
                            <dl class="layui-nav-child">
                                <?php
                                    if ($type_id == 1004) {
                                        echo "<dd><a href='../system/rights_center.php'><i class='layui-icon layui-icon-tabs'></i>&nbsp;权限管理</a></dd>";
                                        echo "<dd><a href='../system/feedBack.php'><i class='layui-icon layui-icon-survey'></i>&nbsp;意见反馈</a></dd>";
                                    }
                                ?>
                                <dd><a href="../system/sysInfo.php"><i class="layui-icon layui-icon-about"></i>&nbsp;系统信息</a></dd>
                            </dl>
                        </li>

                        <li class="layui-nav-item"><a href="https://ymck.me" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;友情链接</a></li>
                    <li class="layui-nav-item"><a href="https://ruancang.net" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;友情链接</a></li>
                    <li class="layui-nav-item"><a href="https://www.qijishow.com" target="_blank"><i class="layui-icon layui-icon-util"></i>&nbsp;小工具</a></li>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <!-- 可通过多字段查询，书名，作者，ISBN，出版社，分类名称，模糊查询，  可选功能把查询出的内容导出Excel-->
            <fieldset class="layui-elem-field layui-field-title" style="border: 1px solid #C9C9C9;margin: 15px 20px 0 20px;">
                <legend>图书检索</legend>
                <div class="layui-form layui-form-pane" lay-filter="form_data" style="margin: 20px;display: flex;text-align: center">
                    <div class="layui-form-item" style="width: 120px;">
                        <div class="layui-input-inline" style="width: 120px;">
                            <select name="keywords_type" lay-filter="keys">
                                <option value="0">书名</option>
                                <option value="1">作者</option>
                                <option value="2">ISBN</option>
                                <option value="3">出版社</option>
                                <option value="4">图书类别</option>
                                <option value="5">藏书位置</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="width: 400px;margin-right: 10px;">
                            <input style="height: 45px;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入搜索关键词" class="layui-input">
                        </div>
                        <button class="layui-btn" style="height: 43px;" id="search"><i class='layui-icon layui-icon-search'></i> 搜索</button>
                    </div>
                </div>
            </fieldset>
            <table class="layui-hide" id="dataList" lay-filter="test"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class='layui-btn layui-btn-sm layui-btn-primary' lay-event='sunshine' id='sunshine'><i class='layui-icon layui-icon-diamond'></i></button>
                </div>
            </script>
            <script type="text/html" id="barDemo">
                <a class='layui-btn layui-btn-xs' lay-event='detail'>查看</a>
            </script>
            <script type="text/html" id="img"> <img src="{{d.book_cover}}" width="32" height="30" alt=""> </script>
            <script type="text/html" id="status">
                <p class="{{d.status == 0 ? 'have' : 'use'}}">{{d.status == 0 ? '在库' : '已借出'}}</p>
            </script>
            <div id="laypage" style="position: fixed;bottom: 42px;border-style: solid;border-color: #eee;z-index:999;width: 100%;background: #fff;"></div>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2023 by Jason Liu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../../skin/images/beian.png" alt=""/>滇ICP备2023001154号-1</a>
                <!-- <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>-->
            </p>
        </div>
    </div>

    <script src="../../skin/js/layui.simple.js"></script>
    <script>
        layui.use(['table', 'laypage', 'form'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,table = layui.table
                ,form = layui.form
                ,laypage = layui.laypage
                ,pageNo = 1  //当前页码
                ,pageSize = 10;  //每页条数

            let data = form.val('form_data');
            let keywords = $.trim(data.keywords);
            let keywords_type = data.keywords_type;

            let url = "../../controllers/books_source/search_booksData.php";  //搜索传回数据的url

            // 创建渲染实例
            table.render({
                elem: '#dataList',
                type: 'POST',
                url: url,  //渲染列表
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
                    page: pageNo,
                    limit: pageSize,
                    keywords: keywords,
                    keywords_type: keywords_type
                },
                toolbar: '#toolbarDemo',
                height: 'full-315', // 最大高度减去其他容器已占有的高度差
                cellMinWidth: 100,
                // totalRow: true, // 开启合计行
                page: false, //开启分页
                even: true, //隔行换色
                loading: true,
                defaultToolbar: ['filter', 'exports'],
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
                        width: 105,
                        title: '图书编号',
                        sort: true,
                        align: 'center'
                    },{
                        field: 'ISBN',
                        width: 180,
                        title: 'ISBN',
                        sort: true,
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
                        field: 'book_type',
                        width: 150,
                        title: '图书类别',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'publisher',
                        width: 150,
                        title: '出版社',
                        align: 'center'
                    }, {
                        field: 'price',
                        title: '价格(元)',
                        width: 90,
                        align: 'center',
                        sort: true
                    }, {
                        field: 'number',
                        title: '库存(本)',
                        width: 90,
                        align: 'center',
                        sort: true
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
                        minWidth: 300,
                        align: 'left',
                        style: '-moz-box-align: start;'
                    }, {
                        field: 'save_position',
                        width: 190,
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
                    },{
                        field: 'borrow_num',
                        width: 120,
                        title: '借阅次数',
                        align: 'center',
                        style: '-moz-box-align: start;'
                    }, {
                        field: 'create_date',
                        width: 175,
                        title: '入库时间',
                        align: 'center',
                        style: '-moz-box-align: start;'
                    }, {
                        fixed: 'right',
                        title: '操作',
                        width: 120,
                        align: 'center',
                        toolbar: '#barDemo'
                    }]
                ],
                done: function (res, curr, count){
                    hoverOpenImg();//显示大图
                    // console.log(res);
                    //在获取到表格数据后加载分页组件，点击分页时调用table的reload方法重新加载表格数据达到分页效果
                    laypage.render({
                        elem: 'laypage', //分页容器ID
                        count: res.count, //通过后台拿到总页数
                        curr: pageNo, //当前页码
                        limit: pageSize, //分页大小
                        limits: [10,15,20,30],
                        groups: 3,  //连续出现的页码数
                        layout: ['prev', 'page', 'next', 'skip', 'count', 'limit'],
                        jump: function (obj, first) {  //跳转方法
                            // console.log(obj);
                            let data = form.val('form_data');
                            let keywords = $.trim(data.keywords);
                            if (!first) {  //若不为第一页
                                pageNo = obj.curr;  //设置全局变量page 为当前选择页码
                                pageSize = obj.limit;  //设置全局变量limit 为当前选择分页大小
                                table.reload('dataList', { //重新加载表格
                                    where: {   //接口参数，page为分页参数
                                        page: pageNo,
                                        limit: pageSize,
                                        keywords: keywords,
                                        keywords_type: data.keywords_type
                                    }
                                })
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
                    case 'sunshine':
                        layer.tips('枕上诗书闲处好，门前风景雨来佳。', '#sunshine',{
                            tips: [1,'#666'],
                            time: 1500
                        });
                        break;
                }
            })

            //触发单元格工具事件
            table.on('tool(test)', function(obj) { // 双击 toolDouble
                let data = obj.data;
                // console.log(data);
                let id = data.book_id;
                // 图书详情url
                let url = '../books_source/book_detail.php?id='+id;
                // alert(url);
                // console.log(obj);
                if (obj.event === 'detail') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-search"></i> 图书详情',
                        type: 2,
                        area: ['48%', '88%'],
                        content: url,
                        skin: 'layui-layer-molv',
                        maxmin: true,
                        shadeClose: true,
                        scrollbar: false  //弹窗锁定滚动条
                    })
                }
            })

            //搜索功能
            function search(){
                let data = form.val('form_data');
                // console.log(data);
                let keywords = $.trim(data.keywords);
                // console.log(keywords);
                if(keywords === ''){
                    layer.msg('请输入关键词',{
                        time: 1500,
                        anim: 6,
                        icon: 7
                    })
                }else {
                    table.reload('dataList', {
                        url: url,
                        page: false, //开启分页
                        where: {
                            keywords: keywords,
                            keywords_type: data.keywords_type
                        }
                    })
                }
            }
            //点击按钮搜索
            $('#search').on('click', function (){
                search();
            })

            //绑定enter回车搜索
            $(document).keyup(function (event) {
                if (event.keyCode == '13') {
                    search();
                }
            })

            //切换搜索类型时清除内容
            form.on("select(keys)",function(value){
                $('#key').val('');
                let data = form.val('form_data');
                // console.log(data);
                let keywords = $.trim(data.keywords);
                table.reload('dataList', {
                    url: url,
                    page: false, //关闭分页
                    where: {
                        keywords: keywords,
                        keywords_type: data.keywords_type
                    }
                })
            })

            //监听当输入框等于空时自动渲染全部数据
            $('#key').bind('input property-change', function (obj){
                let data = form.val('form_data');
                let keywords = $.trim(data.keywords);
                if(keywords === ''){
                    table.reload('dataList',{
                        url: url,
                        page: false, //开启分页
                        where: {
                            keywords: keywords
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
