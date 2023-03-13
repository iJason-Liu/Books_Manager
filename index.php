<?php
    session_start(); //开启session

    //获取后台页面传过来的用户名参数
    $user = $_GET['user'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>数字图书馆中心</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="./images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
<!--        仅pc访问设置上一行代码，手机端显示设置下面两行代码-->
    <!--    <meta name="viewport" content="width=device-width">-->
<!--    <meta name="viewport" content="width=750px,user-scalable=no">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="小新的主站，图书管理系统，PHP，MySQL">
    <meta name="description" content="基于PHP+MySQL开发的图书管理系统">
    <link rel="stylesheet" type="text/css" href="./css/layui.css" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        header {
            height: 35px;
            width: 99%;
            line-height: 35px;
            padding: 0 10px;
            background: #393d49;
            color: #ffffff;
            position: fixed;
            top: 0;
            z-index: 999;
        }

        header a {
            text-decoration: none;
            color: #ffffff;
        }

        .top_right {
            float: right;
            margin-right: 10px;
        }

        .logo {
            height: 80px;
            width: 200px;
            padding-top: 5px;
        }

        .layui-nav * {
            font-size: 16px !important;
        }

        .books_recomend {
            margin-top: 75px;
            padding: 0 80px;
        }

        .r_title {
            width: 100%;
        }
        .back {
            width: 50px;
            height: 50px;
            position: fixed;
            z-index: 999;
            bottom: 60px;
            right: 20px;
            cursor: pointer;
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <span>欢迎访问数字图书馆！</span>
        <div class='top_right'>
<!--            <a href='./login/login.php'>登录 </a> &nbsp; | &nbsp; <a href='./register/register.php'> 注册</a>-->
            <?php
                if($user != ''){
                    echo "您好！<a href='javascript:history.back(-1);'>$user </a> &nbsp; | &nbsp; <a href='./login/logout.php'> 注销登录</a>";
                }else{
                    echo "<a href='./login/login.php'>读者登录入口</a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="./index.php"> <img alt="logo" class="logo" src="./images/logo.png" />
            </a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm layui-this"> <a href="./index.php">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm "> <a href="./index.php">资讯中心</a> </li>
                <li class="layui-nav-item hc-hide-sm "> <a href="./index.php">图书中心</a> </li>
                <li class="layui-nav-item hc-hide-sm "> <a href="./index.php">关于系统</a> </li>

<!--                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort/books_sort.php?id=1">文学类</a> </li>-->
<!--                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort/books_sort.php?id=2">冒险类</a> </li>-->
<!--                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort/books_sort.php?id=3">励志类</a> </li>-->
<!--                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort/books_sort.php?id=4">历史类</a> </li>-->
                <li class="layui-nav-item hc-show-sm"> <a href="javascript:;">更多</a>
                    <dl class="layui-nav-child">
                        <dd class=""><a href="books_sort/books_sort.php?id=1001">政治、法律</a></dd>
                        <dd class=""><a href="books_sort/books_sort.php?id=1002">文学</a></dd>
                        <dd class=""><a href="books_sort/books_sort.php?id=1006">历史、地理</a></dd>
                        <dd class=""><a href="books_sort/books_sort.php?id=8">经济</a></dd>
                        <dd class=""><a href="books_sort/books_sort.php?id=9">更多...</a></dd>
<!--                        <dd class=""><a href="books_sort/books_sort.php?id=10">著作类</a></dd>-->
                    </dl>
                </li>
            </ul>

        </div>
    </nav>

    <div class="layui-carousel" id="carousel">
        <div carousel-item>
            <div>
                <img class="banner" src="./images/banner-1.png" />
            </div>
            <div>
                <img class="banner" src="./images/banner-2.png" />
            </div>
            <div>
                <img class="banner" src="./images/banner-3.png" />
            </div>
        </div>
    </div>

    <div class="books_recomend">
        <div class="r_title">推荐图书</div>
        <div>
            图书数据
        </div>
        <p>未完待续...</p>
    </div>
    <div style="width: 80%;padding: 45px;margin: 40px auto;border: 1px dashed;">
        <img style="width: 100%" src="./images/前端示意图.png">
    </div>

    <div class="layui-footer" style="width: 100%;height: 70px;margin: 300px 0 0 0;text-align: center;background: #9f9f9f;padding: 30px auto">
        <p>
<!--           Copyright © 2023 Jason Liu-->
            小新的主站
        </p>
        <p>
            网站ICP备案号：<a href="https://beian.miit.gov.cn/" target="_blank">滇ICP备2023001154号-1</a>
        </p>
        <p>
            <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="./images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>
        </p>
    </div>

    <img id="gotoTop" title="返回顶部" class="back" src="./images/gotop.png" />

    <script type="text/javascript" src="./js/layui.simple.js"></script>
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        layui.use(['carousel'], function() {
            let carousel = layui.carousel;
            //建造实例
            carousel.render({
                elem: '#carousel',
                width: '100%', //设置容器宽度
                height: '520px',
                arrow: 'hover', //始终显示箭头
                interval: 3500,
                // anim: 'fade', //切换动画方式
                indicator: 'inside'
            });
        });
    </script>
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
</body>

</html>