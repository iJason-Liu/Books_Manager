<?php
    /*
     * 图书中心页面,包括图书查询,根据分类(kind)查询
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
    <title>图书资源中心</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../skin/images/favicon.png"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
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
            color: #8a8a8a !important;
        }
        .layui-nav-child dd a:hover{
            color: #333 !important;
        }

        .content{
            padding: 80px 150px;
        }

        .list_show{
            padding: 0 20px;
            background: #fff;
            border-radius: 4px;
        }

        .biaotou{
            height: 75px;
            width:100%;
            border-bottom: 3px solid #429488;
            line-height: 75px;
        }

        .list_container{
            padding-bottom: 60px;
        }
        .list_item{
            width: 154px;
            margin: 30px 0 0 30px;
            padding: 6px;
            flex-direction: column;
            justify-content: flex-start;
            border: 1px solid #F5F5F5;
            cursor: pointer;
            border-radius: 3px;
        }
        .list_item:hover{
            border: 1px solid #D0DCE0;
        }
        .img_box{
            width: 140px;
            height: 190px;
            overflow: hidden;
        }
        .list_img{
            width: 100%;
            height: 100%;
            border-radius: 2px;
            transition: all 0.5s;
        }
        .list_img:hover{
            transform: scale(1.2);
        }
        .list_name{
            width: 140px;
            padding: 4px 0;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .list_author{
            color: #999;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .right_content{
            background: #fff;
            padding: 0 20px 20px 20px;
            border-left: 3px solid #f8f8f8;
        }

        .title_dot{
            width: 6px;
            height: 24px;
            background: #429488;
            display: inline-block;
            margin-bottom: -6px;
            margin-right: 6px;
        }

        .right_title{
            font-size: 22px;
            border-bottom: 3px solid #429488;
            padding-bottom: 13px;
            padding-top: 25px;
        }

        /*背景色 #808080  #736F6E #837E7C  */
        .layui-footer{
            text-align: center;
            /*background: linear-gradient(#999999,#808080);*/
            background: linear-gradient(#9D9D9D,#8E8E8E);
            color: #444;
            padding: 20px 150px;
            /*box-shadow: 0 3px 10px #ddd;*/
        }
        .layui-footer a{
            color: #444;
        }
        .layui-footer a:hover{
            color: #222;
        }

        .footer_hr{
            margin: 20px 0;
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
                    echo "您好！$user &nbsp; &nbsp; <a href='../administrator/index.php'>后台 </a> &nbsp; | &nbsp; <a href='../login/logout.php'> 注销</a>";
                }else{
                    echo "<a href='../login/login.php'><i class='layui-icon layui-icon-username'></i> 登录 </a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="../index.php"> <img alt="logo" class="logo" src="../skin/images/logo.png" /></a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm hc-hide-xs"> <a href="../index.php">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm layui-this">
                    <a href="javascript:;">资源</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/search_bookData.php" target="_blank">馆藏查询</a></dd>
                        <dd class="layui-this"><a href="../views/book_center.php" target="_blank">馆藏资源</a></dd>
                        <dd><a href="../views/new_book.php">新书通报</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">服务</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/reader_center.php">借阅卡服务</a></dd>
                        <dd><a href="javascript:;">自助打印</a></dd>
                        <dd><a href="javascript:;">借阅指南</a></dd>
                        <dd><a href="javascript:;">图书捐赠</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">动态</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/notice_list.php#news">新闻资讯</a></dd>
                        <dd><a href="../views/notice_list.php#notice">通知公告</a></dd>
                        <dd><a href="javascript:;">活动信息</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">关于</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/about.php">项目介绍</a></dd>
                        <dd><a href="https://mp.weixin.qq.com/s/ccWx9YN5-U2Ut3XDpwYq-w">图书馆介绍</a></dd>
                        <dd><a href="https://mp.weixin.qq.com/s/eMThZAwR6I7PA-wPmRj8KQ">馆藏分布</a></dd>
                        <dd><a href="javascript:;">开放时间</a></dd>
                        <dd><a href="javascript:;">常见问题</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-md hc-show-sm"> <a href="javascript:;">菜单</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../index.php">首页</a></dd>
                        <dd><a href="../views/book_center.php">资源</a></dd>
                        <dd><a href="../views/reader_center.php">服务</a></dd>
                        <dd><a href="../views/notice_list.php">动态</a></dd>
                        <dd><a href="../views/about.php">关于</a></dd>
                        <dd><a href="../register/register.php" target="_blank">Register</a></dd>
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
        <div class="layui-row layui-col-space10">
            <div class="layui-col-md8 layui-col-sm8 list_show">
                <div class="biaotou">
                    <span style="font-size: 22px;">
                        <img width="52" height="52" src="../skin/images/other/book_4.png" >&nbsp;
                        馆藏资源(20本)
                    </span>
                    <div style="float: right;">
                        <a href="../views/search_bookData.php"><i class="layui-icon layui-icon-search"></i> 搜索图书</a>
                    </div>
                </div>
                <div class="layui-row layui-col-space30 list_container">
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s29260063.jpg">
                        </div>
                        <div class="list_name">
                            三生三世十里桃花加长测试
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s123452.jpg">
                        </div>
                            <div class="list_name">
                            人间草木
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/book-default.gif">
                        </div>
                            <div class="list_name">
                            三生三世十里桃花
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s237622.jpg">
                        </div>
                            <div class="list_name">
                            放生羊
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/book-default.gif">
                        </div>
                            <div class="list_name">
                            夜读
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s206577.jpg">
                        </div>
                            <div class="list_name">
                            人间值得
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/sampling.webp">
                        </div>
                            <div class="list_name">
                            三生三世十里桃花,三生三世十里桃花三生三世十里桃花
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s29506438.jpg">
                        </div>
                            <div class="list_name">
                            茶花女
                        </div>
                        <div class="list_author">
                            作者：[法国]小仲马
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s206573.jpg">
                        </div>
                        <div class="list_name">
                            三生三世十里桃花,三生三世十里桃花三生三世十里桃花
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s29260063.jpg">
                        </div>
                        <div class="list_name">
                            三生三世十里桃花,三生三世十里桃花三生三世十里桃花
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4 list_item">
                        <div class="img_box">
                            <img class="list_img" src="../upload/bookCover/s206578.jpg">
                        </div>
                        <div class="list_name">
                            三生三世十里桃花,三生三世十里桃花三生三世十里桃花
                        </div>
                        <div class="list_author">
                            作者：唐七
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md4 layui-col-sm4 right_content">
                <div class="layui-col-md12 right_title">
                    <span class="title_dot"></span>热门图书 TOP10
                </div>
                <div class="layui-col-md12 layui-elip" style="margin-top: 18px;">
                    <span class="layui-badge">1</span>&emsp;图书名称图书名称图书名称图书名称图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-orange">2</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-blue">3</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">4</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">5</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">6</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">7</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">8</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">9</span>&emsp;图书名称
                </div>
                <div class="layui-col-md12" style="margin-top: 20px;">
                    <span class="layui-badge layui-bg-gray">10</span>&emsp;图书名称
                </div>
            </div>
        </div>
    </div>

    <div class="layui-footer">
        <div class="layui-row layui-col-space25">
            <!--<div class="layui-col-md3 hc-hide-sm">-->
            <!--    <img width="210" height="110" src="./skin/images/logo.png">-->
            <!--</div>-->
            <div class="layui-col-md5 layui-col-sm6" style="text-align: left;">
                <div class="layui-row">
                    <div class="layui-col-md12">
                        <h2>联系我们</h2>
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
            <div class="layui-col-md4 layui-col-sm4" style="text-align: left;">
                <div class="layui-row">
                    <div class="layui-col-md12">
                        <h2>友情链接</h2>
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
            <div class="layui-col-md3 layui-col-sm2">
                <a href="https://lib.crayon.vip"><img width="98" height="98" src="../skin/images/qrcode.png"></a>
            </div>
        </div>
        <hr class="footer_hr">
        <div class="layui-row">
            <div class="layui-col-md12">
                Copyright ©  2023.6 Jason Liu<a href="https://lib.crayon.vip" target="_blank" style="margin-left: 30px;">https://lib.crayon.vip</a>
            </div>
            <div class="layui-col-md12" style="margin-top: 10px;">
                网站ICP备案号：<a href="https://beian.miit.gov.cn/" target="_blank">滇ICP备2023001154号-1</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../skin/images/beian.png" alt="" style="margin-top: -3px;"/> 滇公网安备 53252702252753号</a>
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
        layui.use(['carousel', 'layer', 'tree'], function() {
            let carousel = layui.carousel
                    ,layer = layui.layer;

            //建造轮播实例
            carousel.render({
                elem: '#carousel',
                width: '100%', //设置容器宽度
                height: '520px',
                // arrow: 'hover', //始终显示箭头
                // interval: 3500,
                // anim: 'fade', //切换动画方式
                indicator: 'none'
            });

            //和风天气API
            // $.ajax({
            //     url: 'https://devapi.qweather.com/v7/weather/now',
            //     type: 'GET',
            //     async: false,
            //     data: {
            //         key: 'a2199007974e45058c3c3e0ba101ea35',  //认证信息 token
            //         location: '101010100'  //北京
            //     },
            //     // header: 'Access-Control-Allow-Origin:*',  //解决跨域请求
            //     dataType: 'json',
            //     success: function (res){
            //         console.log(res);
            //         // layer.open({
            //         //     title: '天气预报',
            //         //     type: 2,
            //         //     area: ['48%','88%'],
            //         //     maxmin: true,
            //         //     content: res.fxLink,
            //         // })
            //     }
            // })
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
