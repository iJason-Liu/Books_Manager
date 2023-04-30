<?php
    /*
     * 图书推荐和图书排行的二级页面，显示图书详情，评论，在线阅读
    */
    session_save_path('../session/');
    session_start(); //开启session
    include "../login/session_time.php";

    //获取全局变量用户名参数
    $user = $_SESSION['user'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>图书详情查看</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../skin/images/favicon.png"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="../skin/css/layui.min.css"/>
    <link rel="stylesheet" href="../skin/css/modules/layer/layer.css">
    <link rel="stylesheet" type="text/css" href="../skin/css/index.css"/>
    <style>
        header {
            height: 40px;
            width: 100%;
            line-height: 40px;
            padding: 0 20px;
            background: #393d49;
            color: #ffffff;
            position: fixed;
            top: 0;
            z-index: 9;
        }

        header a {
            text-decoration: none;
            color: #ffffff;
        }

        .top_right {
            float: right;
            margin-right: 40px;
        }

        .logo {
            height: 80px;
            width: 200px;
            padding-top: 7px;
        }

        .layui-main{
            width: 100%;
        }

        .layui-carousel{
            margin-top: 135px;
        }

        .layui-nav * {
            font-size: 18px !important;
        }

        .layui-nav .layui-nav-more{
            right: -12px;
        }
        .layui-nav .layui-nav-item a{
            padding: 0 10px;
        }
        .layui-nav-child dd a{
            padding: 0 20px !important;
        }

        .content{
            padding: 80px 150px;
        }

        /*背景色 #808080  #736F6E #837E7C  */
        .layui-footer{
            text-align: center;
            background: linear-gradient(#999999,#808080);
            color: #222222;
            padding: 30px 150px;
        }
        .layui-footer a:hover{
            color: #222222;
        }

        hr{
            margin: 25px 0;
            color: #f8f8f8;
        }
    </style>
</head>

<body>
    <header>
        <div style="float: left;">
            <span>欢迎访问小新的主站！</span>
        </div>
        <span style="margin-left: 30px;">
            <marquee width=460 scrollamount=3 direction=left align=middle><script src="https://weiluge.jdzjw.com/tools/one/api.php"></script></marquee>
        </span>
        <div class='top_right'>
            <?php
                if($user != ''){
                    echo "您好！$user &nbsp; &nbsp; <a href='../administrator/index'>后台 </a> &nbsp; | &nbsp; <a href='../login/logout'> 注销</a>";
                }else{
                    echo "<a href='../login/login'><i class='layui-icon layui-icon-username'></i> 登录 </a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="../index"> <img alt="logo" class="logo" src="../skin/images/logo.png" /></a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm hc-hide-xs"> <a href="../index">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm layui-this"> <a href="../views/book_center">图书资源</a> </li>
                <li class="layui-nav-item hc-hide-sm"> <a href="../views/notice_list">新闻动态</a> </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="../views/reader_center">读者服务</a>
                    <dl class="layui-nav-child">
                        <dd><a href="">读者导航</a></dd>
                        <dd><a href="">自助打印</a></dd>
                        <dd><a href="">借阅服务</a></dd>
                        <dd><a href="">图书捐赠</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm"> <a href="../views/about">关于系统</a> </li>
                <li class="layui-nav-item hc-hide-md hc-show-sm"> <a href="javascript:;">菜单</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../index">首页</a></dd>
                        <dd><a href="../views/book_center">图书资源</a></dd>
                        <dd><a href="../views/notice_list">新闻动态</a></dd>
                        <dd><a href="../views/notice_list">读者服务</a></dd>
                        <dd><a href="../views/about">关于系统</a></dd>
                        <dd><a href="../register/register" target="_blank">灰度测试(reg)</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </nav>

    <div class="layui-carousel" id="carousel">
        <div carousel-item>
            <div>
                <img class="banner" src="../skin/images/banner/banner_9.png" />
            </div>
        </div>
    </div>

    <div class="content">
        <div class="layui-row layui-col-space5">
            <div class="layui-col-md4 layui-col-sm4">
                侧边导航
            </div>
            <div class="layui-col-md8 layui-col-sm8">
                显示图书内容，介绍
            </div>
        </div>
    </div>

    <div class="layui-footer">
        <div class="layui-row layui-col-space25">
            <div class="layui-col-md3 hc-hide-sm">
                <img width="210" height="110" src="./skin/images/logo.png">
            </div>
            <div class="layui-col-md4 layui-col-sm5" style="text-align: left;">
                <div class="layui-row">
                    <div class="layui-col-md12">
                        <h3>联系我们</h3>
                    </div>
                    <div class="layui-col-md12" style="margin-top: 10px;">
                        联系方式：18987319503
                    </div>
                    <div class="layui-col-md12">
                        邮箱：crayon996@gmail.com
                    </div>
                    <div class="layui-col-md12">
                        邮编：678000
                    </div>
                    <div class="layui-col-md12">
                        地址：云南省保山市隆阳区远征路16号
                    </div>
                </div>
            </div>
            <div class="layui-col-md3 layui-col-sm5" style="text-align: left;">
                <div class="layui-row">
                    <div class="layui-col-md12">
                        <h3>友情链接</h3>
                    </div>
                    <div class="layui-col-md12" style="margin-top: 10px;">
                        <a href="https://www.bsnc.cn" target="_blank">保山学院</a>
                    </div>
                    <div class="layui-col-md12">
                        <a href="https://tsg.bsnc.cn/" target="_blank">保山学院图书馆</a>
                    </div>
                    <div class="layui-col-md12">
                        <a href="http://share.zjlib.cn/area/35594/2120" target="_blank">浙江图书馆</a>
                    </div>
                    <div class="layui-col-md12">
                        <a href="https://lib.nankai.edu.cn/main.htm" target="_blank">南开大学图书馆</a>
                    </div>
                </div>
            </div>
            <div class="layui-col-md2 layui-col-sm2">
                <a href="https://lib.crayon.vip"><img width="98" height="98" src="./skin/images/qrcode.png"></a>
            </div>
        </div>
        <hr>
        <div class="layui-row">
            <div class="layui-col-md12">
                Copyright ©  2023.6 Jason Liu<a href="https://lib.crayon.vip" target="_blank" style="margin-left: 30px;">https://lib.crayon.vip</a>
            </div>
            <div class="layui-col-md12" style="margin-top: 10px;">
                网站ICP备案号：<a href="https://beian.miit.gov.cn/" target="_blank">滇ICP备2023001154号-1</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="./skin/images/beian.png" alt="" style="margin-top: -3px;"/> 滇公网安备 53252702252753号</a>
            </div>
            <div class="layui-col-md12" style="margin-top: 15px;">
                <i class="layui-icon layui-icon-group layui-font-26"></i>您是第 <span class="visitor"></span> 位访客
            </div>
        </div>
    </div>

    <img id="gotoTop" title="返回顶部" class="back" src="../skin/images/gotop.png"/>

    <script src="../skin/js/layui.min.js"></script>
    <script src="../skin/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        layui.use(['carousel', 'layer'], function() {
            let carousel = layui.carousel
                    ,layer = layui.layer;

            //建造轮播实例
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
        //pv
        let i = 0;
        $('.visitor').text('1011');

        function gotoTop(minHeight) {
            // 定义点击返回顶部图标后向上滚动的动画
            $("#gotoTop").click( function() {
                $('html,body').animate({
                    scrollTop: '0px'
                }, 'slow');
            })
            // 获取页面的最小高度
            minHeight ? minHeight = minHeight : minHeight = 100;
            // 为窗口的scroll事件绑定处理函数
            $(window).scroll(function() {
                // 获取窗口的滚动条的垂直滚动距离
                let s = $(window).scrollTop();
                // 当窗口的滚动条的垂直距离大于页面的最小高度时，让返回顶部图标渐现，否则渐隐
                if (s > minHeight) {
                    $("#gotoTop").fadeIn(500);
                } else {
                    $("#gotoTop").fadeOut(500);
                }
            })
        }
        gotoTop();
    </script>
</body>

</html>
