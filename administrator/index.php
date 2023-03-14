<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    $user = $_SESSION['user'];
    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $typ = $_SESSION['usertype']; //用户登录时的身份
//    echo $typ.'111';
    $check_sql = "select type_id from user_type where usertype_name='$typ'";
    $res = mysqli_query($db_connect, $check_sql);

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <title>后台系统管理大厅</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../css/layui.css">
    <script type="text/javascript" src="../js/layui.simple.js"></script>
    <style>
        .show{
            display: block !important;  //隐藏功能
        }
        .hide{
            display: none !important;
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
                <li class="layui-nav-item layui-hide-xs layui-this"><a href="../administrator/index.php">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../index.php?user=<?php echo $user ?>">前台首页</a></li>
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
                <li class="layui-nav-item layui-hide-xs layui-show-md-inline-block">
                    <a href="javascript: void(0);">
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

        <?php
            while($row = mysqli_fetch_array($res)){
                $type_id = $row['type_id'];
        ?>
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item">
                        <a class="" href="javascript:;">个人中心</a>
                        <dl class="layui-nav-child">
                            <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <dd><a href="../user_center/user_Info.php">信息管理</a></dd>
                            <dd><a href="../user_center/update_pwd.php">修改密码</a></dd>
                            <dd><a href="../user_center/account_del.php">账号注销</a></dd>
                        </dl>
                    </li>

                    <!-- 判断身份为超级管理员时显示 -->
                    <li class="layui-nav-item
                    <?php
                        if($type_id == 1004){
                            echo "show";
                        }else{
                            echo "hide";
                        }
                    ?>">
                        <a href="javascript:;">馆员中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../lib_worker/worker_list.php">馆员档案</a></dd>
                        </dl>
                    </li>

                    <!-- 学生、教师不显示 -->
                    <li class="layui-nav-item
                    <?php
                        if($type_id == 1003 || $type_id == 1004){
                            echo "show";
                        }else{
                            echo "hide";
                        }
                    ?>">
                        <a href="javascript:;">读者中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../reader/reader_info.php">读者档案</a></dd>
                            <dd><a href="../reader/reader_kind.php">读者类型</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a class="" href="javascript:;">图书管理</a>
                        <dl class="layui-nav-child">
                            <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd><a href="../books/books_list.php">馆藏图书</a></dd>
                            <dd><a href="../books/books_check.php">图书查询</a></dd>
                            <!-- 图书点击量，借阅次数 -->
                            <dd><a href="../books/books_test.php">人气图书</a></dd>
                            <!-- 包含查询，书库名，编号，位置 -->
                            <dd><a href="../books/books_stack.php">书库信息</a></dd>
                            <dd><a href="../books/books_type.php">图书类别</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">流通管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../books_usage/borrow_status.php">图书借阅</a></dd>
                            <!-- 续借操作，每次完成续借时间推迟7天  -->
                            <dd><a href="../books_usage/renewBook.php">图书续借</a></dd>
                            <dd><a href="../books_usage/returnBook">图书归还</a></dd>
                        </dl>
                    </li>

                    <!-- 评论只允许管理员和超级管理员查看 -->
                    <li class="layui-nav-item
                    <?php
                        if($type_id == 1003 || $type_id == 1004){
                            echo "show";
                        }else{
                            echo "hide";
                        }
                    ?>">
                        <a href="javascript:;">评论管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../comment/comment_center.php">评论中心</a></dd>
                            <dd><a href="../comment/comment_control.php">评论风控</a></dd>
                        </dl>
                    </li>

                    <!-- 仅超级管理员显示权限管理 -->
                    <li class="layui-nav-item">
                        <a href="javascript:;">系统维护</a>
                        <dl class="layui-nav-child">
                            <?php
                                if($type_id == 1004){
                                    echo "<dd><a href='../system/rights_mag.php'>权限管理</a></dd>";
                                }
                            ?>
                            <dd><a href="../system/sysInfo.php">系统信息</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item"><a href="https://cupfox.app/" target="_blank">友情链接</a></li>
                    <li class="layui-nav-item"><a href="https://qinggongju.com/#tab-19-308" target="_blank">小工具</a></li>
                </ul>
            </div>
        </div>
        <?php
            }
        ?>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">欢迎来到小新的图书管理系统中心！</div>
<!--            <p>这里还应该放一个搜索框进行搜索书库中的书籍，使用二级页面显示查询的信息。</p>-->
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2023 by Jason Liu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;https://www.crayon.vip&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../images/beian.png" alt=""/>滇ICP备2023001154号-1</a>
                <!--                <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>-->
            </p>
        </div>
    </div>
</body>

</html>