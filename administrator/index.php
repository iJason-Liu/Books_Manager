<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if ($_SESSION['is_flag'] != 2) {
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }

    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $type = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select type_id from user_type where usertype_name='$type'";
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
        /*
        * 隐藏功能
         */
        .show{
            display: block !important;
        }
        .hide{
            display: none !important;
        }
    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function(){ return false;}
        //禁用浏览器右键点击事件
        document.oncontextmenu = function(){return false;}
        //禁止拖拽
        document.ondragstart=function(){return false}
        //禁止用户选中网页上的内容
        // document.onselectstart=function(){return false}
        //禁用复制剪贴版
        document.onbeforecopy=function(){return false}
        //禁用文本框或者文本域中的文字被选中
        // document.onselect=function(){return false;}
    </script>
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
                <li class="layui-nav-item layui-hide-xs"><a href="../index.php">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide.php">帮助中心<span class="layui-badge">1</span></a></li>
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
                        <dd><a href="../user_center/user_Info.php">个人中心</a></dd>
                        <dd><a href="../user_center/update_pwd.php">修改密码</a></dd>
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
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-username"></i>&nbsp;个人中心</a>
                        <dl class="layui-nav-child">
                            <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <dd><a href="../user_center/user_Info.php"><i class="layui-icon layui-icon-username"></i>&nbsp;我的信息</a></dd>
                            <dd><a href="../user_center/update_pwd.php"><i class="layui-icon layui-icon-password"></i>&nbsp;修改密码</a></dd>
                            <dd><a href="../user_center/account_del.php"><i class="layui-icon layui-icon-logout"></i>&nbsp;账号注销</a></dd>
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
                        <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>&nbsp;馆员中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../lib_worker/worker_list.php"><i class="layui-icon layui-icon-group"></i>&nbsp;馆员档案</a></dd>
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
                        <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>&nbsp;读者中心</a>
                        <dl class="layui-nav-child">
                            <dd>
                                <li class="layui-nav-item">
                                    <a href="javascript:;"><i class="layui-icon layui-icon-group"></i>&nbsp;读者档案</a>
                                    <dl class="layui-nav-child layui-nav-child-c">
                                        <dd><a href="../reader/reader_info_student.php"><i class="layui-icon layui-icon-username"></i>&nbsp;学生档案</a></dd>
                                        <dd><a href="../reader/reader_info_teacher.php"><i class="layui-icon layui-icon-username"></i>&nbsp;教师档案</a></dd>
                                    </dl>
                                </li>
                            </dd>
                            <dd><a href="../reader/reader_kind.php"><i class="layui-icon layui-icon-cols"></i>&nbsp;&nbsp;读者类型</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-read"></i>&nbsp;图书管理</a>
                        <dl class="layui-nav-child">
                            <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd><a href="../books/books_list.php"><i class="layui-icon layui-icon-read"></i>&nbsp;馆藏图书</a></dd>
                            <dd><a href="../books/books_search.php"><i class="layui-icon layui-icon-search"></i>&nbsp;图书查询</a></dd>
                            <!-- 图书点击量，借阅次数 -->
                            <dd><a href="../books/popular_books.php"><i class="layui-icon layui-icon-praise"></i>&nbsp;人气图书</a></dd>
                            <dd><a href="../books/books_kind.php"><i class="layui-icon layui-icon-form"></i>&nbsp;图书类别</a></dd>
                            <!-- 包含查询，书库名，编号，位置 -->
                            <dd><a href="../books/books_stack.php"><i class="layui-icon layui-icon-diamond"></i>&nbsp;书库信息</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-template-1"></i>&nbsp;流通管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../books_usage/borrow_status.php"><i class="layui-icon layui-icon-release"></i>&nbsp;图书借阅</a></dd>
                            <!-- 续借操作，每次完成续借时间推迟7天  -->
                            <dd><a href="../books_usage/renewBook.php"><i class="layui-icon layui-icon-refresh"></i>&nbsp;图书续借</a></dd>
                            <dd><a href="../books_usage/returnBook.php"><i class="layui-icon layui-icon-prev-circle"></i>&nbsp;图书归还</a></dd>
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
                                if($type_id == 1004){
                                    echo "<dd><a href='../system/rights_center.php'><i class='layui-icon layui-icon-tabs'></i>&nbsp;权限管理</a></dd>";
                                }
                            ?>
                            <dd><a href="../system/sysInfo.php"><i class="layui-icon layui-icon-about"></i>&nbsp;系统信息</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item
                    <?php
                        if($type_id == 1004){
                            echo "show";
                        }else{
                            echo "hide";
                        }
                    ?>">
                        <a href="javascript:;"><i class="layui-icon layui-icon-link"></i>&nbsp;友情链接</a>
                        <dl class="layui-nav-child">
                            <dd><a href="https://www.crayon.vip/display/swz_web" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;书丸子官网PC</a></dd>
                            <dd><a href="https://crayon.vip/display/swz_mweb" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;书丸子官网WAP</a></dd>
                            <dd><a href="http://43.139.94.135:1011/display" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;服务器root display</a></dd>
                            <dd><a href="http://43.139.94.135:1011/" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;服务器root</a></dd>
                            <dd><a href="http://43.139.94.135:8181/" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;WebScoketChat</a></dd>
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
            <div style="padding: 15px;">欢迎来到小新的图书管理系统中心！</div>
<!--            <p>这里还应该放一个搜索框进行搜索书库中的书籍，使用二级页面显示查询的信息。</p>-->
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2023 by Jason Liu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.crayon.vip">https://www.crayon.vip</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../images/beian.png" alt=""/>滇ICP备2023001154号-1</a>
                <!--                <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>-->
            </p>
        </div>
    </div>
</body>

</html>