<?php
session_start(); //开启session
//图书中心页面,包括图书查询,根据分类(classify)查询

//获取后台页面传过来的用户名参数
$user = $_GET['user'];
//    echo $user.'11';

?>
<!DOCTYPE html>
<html>

<head>
    <title>图书中心</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../images/favicon.png"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="../css/layui.css"/>
    <link rel="stylesheet" type="text/css" href="../css/index.css"/>
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
        <span>欢迎访问小新的主站！</span>
        <div class='top_right'>
            <?php
                if($user != ''){
                    echo "您好！<a href='../administrator/index.php'>$user </a> &nbsp; | &nbsp; <a href='../login/logout.php'> 注销登录</a>";
                }else{
                    echo "<a href='../login/login.php'>读者登录入口</a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="../index.php"> <img alt="logo" class="logo" src="../images/logo.png"/>
            </a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm"><a href="../index.php">首页</a></li>
                <li class="layui-nav-item hc-hide-sm layui-this"><a href="../views/book_center.php">图书中心</a></li>
                <li class="layui-nav-item hc-hide-sm "><a href="../views/notice_list.php">图书资讯</a></li>
                <li class="layui-nav-item hc-hide-sm "><a href="../views/about.php">关于项目</a></li>
                <li class="layui-nav-item hc-show-sm"><a href="javascript:;">更多</a>
                    <dl class="layui-nav-child">
                        <dd class=""><a href="">政治、法律</a></dd>
                        <dd class=""><a href="">文学</a></dd>
                        <dd class=""><a href="">历史、地理</a></dd>
                        <dd class=""><a href="">经济</a></dd>
                        <dd class=""><a href="">更多...</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </nav>

    <div class="layui-carousel" id="carousel">
        <div carousel-item>
            <div>
                <img class="banner" src="../images/banner-1.png"/>
            </div>
        </div>
    </div>

    <div class="books_recomend">
        <div>
            文学类图书书架
        </div>
    </div>
    <div style="width: 80%;padding: 45px;margin: 40px auto;border: 1px dashed;">
        <img style="width: 100%" src="../images/前端示意图.png">
    </div>

    <div class="layui-footer" style="margin: 20px 0 0 0;text-align: center;background: #fafafa;padding: 10px;box-shadow: -1px 0 4px rgb(0 0 0 / 12%);">
        <p>
            Copyright © 2023 &nbsp;&nbsp;<a href="https://www.crayon.vip">https://www.crayon.vip</a>
        </p>
        <br>
        <p>
            网站ICP备案号：<a href="https://beian.miit.gov.cn/" target="_blank">滇ICP备2023001154号-1</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>
        </p>
    </div>

    <img id="gotoTop" title="返回顶部" class="back" src="../images/gotop.png"/>

    <script src="../js/layui.simple.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
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
