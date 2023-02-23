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
    $sql1 = "select * from books";
    $result = mysqli_query($db_connect, $sql1);

    mysqli_close($db_connect); //关闭数据库资源
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
    <link rel="stylesheet" href="../css/modules/code.css?v=3">
    <link rel="stylesheet" href="../css/modules/layer/layer.css?v=3.5.1">
    <link rel="stylesheet" href="../css/modules/laydate/laydate.css?v=5.3.1">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .tab {
            width: 89%;
            margin: 2.2% auto;
            text-align: center;
        }

        .tab tr,
        th,
        td {
            border: 1px solid black;
        }

        .btn {
            width: 90px;
            height: 28px;
            background-color: #009688;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            font-size: 16px;
            border: none;
        }

        .btn1 {
            width: 90px;
            height: 28px;
            background-color: #009688;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            font-size: 16px;
            border: none;
            margin-top: 7px;
        }

        .back {
            width: 50px;
            height: 50px;
            position: fixed;
            z-index: 999;
            bottom: 60px;
            right: 12px;
            cursor: pointer;
            display: none;
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

                <li class="layui-nav-item layui-hide-xs"><a href="../administrator/index.php">首页</a></li>
                <li class="layui-nav-item layui-this">
                    <a href="../books/books_list.php">图书中心</a>
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
            <table class="tab" cellspacing='0' cellpadding="3">
                <tr height="50px">
                    <th colspan="8">
                        <h1>馆藏图书列表</h1>
                    </th>
                    <td>
                        <a href='../books/add_books.php'>
                            <input type="button" name="add" value="添加图书" class="btn" />
                        </a>
                    </td>
                </tr>
                <tr style='background-color:#009688;height:45px'>
                    <th>图书编号</th>
                    <th>图书名称</th>
                    <th>价格(单位:元)</th>
                    <th>作者</th>
                    <th>出版社</th>
                    <th>图书类别</th>
                    <th>库存(单位:本)</th>
                    <th>介绍</th>
                    <th>操作</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td>
                            <?php
                            echo $row["book_id"];
                            ?>
                        </td>
                        <td style="width: 10%;">
                            <?php
                            echo $row["book_name"];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row["price"];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row["author"];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row["publisher"];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row["book_type"];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row["number"];
                            ?>
                        </td>
                        <td width="27%">
                            <?php
                            echo $row["mark"];
                            ?>
                        </td>
                        <td height="90px" width="9%">
                            <a href='../books/books_detail.php?id=<?php echo $row["book_id"]; ?>'>
                                <input type="button" value="查 看" class="btn" />
                            </a>
                            <a href='javascript:;' class="delbtn">
                                <input type="button" data-type="tip" id="del" value="删 除" class="btn1" />
                            </a>
                            <script type="text/javascript" src="../js/layui.js"></script>
                            <script type="text/javascript">
                                layui.use(['layer'], function() {
                                    var $ = layui.jquery, layer = layui.layer;

                                    $('.delbtn #del').click(function() {
                                        // layer.msg("hello!");  //测试
                                        layer.confirm('您是否确认删除此书？', {
                                            title: '温馨提示',
                                            id: 'conDel', //解决重复弹窗
                                            btn: ['确认', '取消'] //按钮
                                        }, function() {
                                            layer.msg('已删除', {
                                                icon: 1
                                            });
                                            location.href = "../books/books_delete.php?id=<?php echo $row["book_id"]; ?>";
                                        }, function() {
                                            layer.msg('取消操作', {
                                                time: 1500, //1.5s后自动关闭
                                            });
                                        });
                                    });
                                })
                            </script>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <img id="gotoTop" title="返回顶部" class="back" src="../images/gotop.png" />

            <div style="padding-bottom: 50px;">

            </div>
            <script type='text/javascript' src='../js/jquery-3.3.1.min.js'></script>
            <script type="text/javascript">
                function gotoTop(minHeight) {
                    // 定义点击返回顶部图标后向上滚动的动画
                    $("#gotoTop").click(
                        function() {
                            $('html,body').animate({
                                scrollTop: '0px'
                            }, 'slow');
                        })
                    // 获取页面的最小高度
                    minHeight ? minHeight = minHeight : minHeight = 100;
                    // 为窗口的scroll事件绑定处理函数
                    $(window).scroll(function() {
                        // 获取窗口的滚动条的垂直滚动距离
                        var s = $(window).scrollTop();
                        // 当窗口的滚动条的垂直距离大于页面的最小高度时，让返回顶部图标渐现，否则渐隐
                        if (s > minHeight) {
                            $("#gotoTop").fadeIn(500);
                        } else {
                            $("#gotoTop").fadeOut(500);
                        };
                    });
                };
                gotoTop();
            </script>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2022 by Jason Liu
            </p>
        </div>
    </div>
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