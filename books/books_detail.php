<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if ($_SESSION['is_flag'] != 2) {
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $id = $_GET['id'];
    //执行sql语句的查询语句
    $sql1 = "select * from books where book_id=$id";
    $result = mysqli_query($db_connect, $sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>图书详情信息</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="https://ymck.me/wp-content/uploads/2022/12/head-removebg-preview-1-1.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../css/layui.css">
    <script type="text/javascript" src="../js/layui.simple.js"></script>
    <style>
        td {
            height: 45px
        }

        textarea {
            font-size: 16px;
        }

        input {
            cursor: pointer;
        }
    </style>
</head>

<body style='background: url(../images/bg3.jpg) top center no-repeat; background-size:cover'>
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

                <li class="layui-nav-item layui-hide-xs"><a href="../administrator/index.php">首页</a></li>
                <li class="layui-nav-item layui-this">
                    <a href="../books/books_list1.php">图书中心</a>
                    <dl class="layui-nav-child">
                        <dd><a href="">人气图书</a></dd> <!--点击量界面展示 -->
                        <dd><a href="">图书类别</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-hide-xs"><a href="../index.php">图书馆首页</a></li>
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
                        <img src="https://xn--gmqz83awjh.org/images/ico/tututu.jpg" class="layui-nav-img">
                        <?php
                        if ($_SESSION['is_flag'] != 2) {
                            echo "<script>alert('您没有权限访问！');location.href='../login/login.php'</script>";
                        } else {
                            echo "您好！" . $_SESSION['user'];
                        }
                        ?>
                    </a>
                    <dl class="layui-nav-child layui-nav-child-c">
                        <!-- <dd><a href="#" style="font-size:14px;">
                            身份：
                        </a></dd> -->
                        <dd><a href="">个人中心</a></dd>
                        <dd><a href="">修改密码</a></dd>
                        <dd><a href="../login/logout.php">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;">个人中心</a>
                        <dl class="layui-nav-child">
                            <!-- 包含注销功能，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <dd><a href="javascript:;">信息管理</a></dd>
                            <dd><a href="javascript:;">修改密码</a></dd>
                        </dl>
                    </li>

                    <!-- 判断身份为超级管理员时显示 -->
                    <!-- <li class="layui-nav-item">
                        <a class="" href="javascript:;">馆员中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">馆员档案</a></dd>
                        </dl>
                    </li> -->

                    <!-- 根据权限判断是否显示(学生教师不显示) -->
                    <!-- <li class="layui-nav-item">
                        <a href="javascript:;">读者中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">读者档案</a></dd>
                            <dd><a href="javascript:;">读者类型</a></dd>
                        </dl>
                    </li> -->

                    <li class="layui-nav-item">
                        <a href="javascript:;">图书查询</a>
                        <dl class="layui-nav-child">
                            <!-- 图书查询包含编号、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd><a href="javascript:;">馆藏图书查询</a></dd>
                            <!-- 包含书库名，编号，位置 -->
                            <dd><a href="javascript:;">书库查询</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">流通管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">图书借阅查询</a></dd>
                            <dd><a href="javascript:;">图书续借</a></dd>
                            <dd><a href="javascript:;">图书归还</a></dd>
                        </dl>
                    </li>

                    <!-- 评论只允许管理员和超级管理员查看 -->
                    <!-- <li class="layui-nav-item">
                        <a href="javascript:;">评论管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">评论中心</a></dd>
                            <dd><a href="javascript:;">评论风控</a></dd>
                        </dl>
                    </li> -->

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
            <h1 align='center' style='margin-top:5%'>图 书 详 情 信 息</h1>
            <form action='books_update.php?id=<?php echo $id; ?>' method='post'>
                <table align='center'>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th style='width:120px'>书本名称:</th>
                            <td>
                                <?php
                                echo $row["book_name"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>书本价格:</th>
                            <td>
                                <?php
                                echo $row["price"];
                                ?>元
                            </td>
                        </tr>
                        <tr>
                            <th>书本作者:</th>
                            <td>
                                <?php
                                echo $row["author"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>出版社:</th>
                            <td>
                                <?php
                                echo $row["publisher"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>图书类别:</th>
                            <td>
                                <?php
                                echo $row["book_type"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>库存:</th>
                            <td>
                                <?php
                                echo $row["number"];
                                ?>本
                            </td>
                        </tr>
                        <tr style='height:145px'>
                            <th>书本介绍:</th>
                            <td>
                                <textarea rows='8' cols='40' style='resize:vertical;letter-spacing:2px;' readonly><?php echo $row["mark"]; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2' align='center'>
                                <input type='submit' value='修 改' class="layui-btn layui-btn-radius" />
                                <input type='button' value='返 回' onclick='window.location.href="../books/books_list.php"' class="layui-btn layui-btn-radius" />
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </form>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2022 by Jason Liu
            </p>
        </div>
    </div>
    
</body>

</html>