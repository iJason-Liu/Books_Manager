<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>后台系统管理大厅</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="https://ymck.me/wp-content/uploads/2022/12/head-removebg-preview-1-1.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../css/layui.css">
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

                <li class="layui-nav-item layui-hide-xs layui-this"><a href="../administrator/index.php">首页</a></li>
                <li class="layui-nav-item">
                    <a href="../books/books_list.php">图书中心</a>
                    <dl class="layui-nav-child">
                        <dd><a href="">人气图书</a></dd>  <!--点击量界面展示 -->
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
                            echo "您好！". $_SESSION['user'];
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
            <div style="padding: 15px;">考虑布局排版，包含图书封面，九宫格布局</div>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                数字图书馆 Copyright © 2022 by Jason Liu
            </p>
        </div>
    </div>
    <script src="../js/layui.js"></script>
    <script>
        //JS 
        layui.use(['element', 'layer', 'util'], function() {
            var element = layui.element,
                layer = layui.layer,
                util = layui.util,
                $ = layui.$;

            //头部事件
            util.event('lay-header-event', {
                //左侧菜单事件
                menuLeft: function(othis) {
                    layer.msg('展开左侧菜单的操作', {
                        icon: 0
                    });
                },
            });

        });
    </script>
</body>

</html>