<!DOCTYPE html>
<html>

<head>
    <title>数字图书馆中心</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="https://ymck.me/wp-content/uploads/2022/12/head-removebg-preview-1-1.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="../css/layui.css" />
    <link rel="stylesheet" type="text/css" href="../css/index.css" />
    <link rel="stylesheet" href="../css/swiper-bundle.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        header {
            height: 35px;
            line-height: 35px;
            padding: 0 10px;
            background: #696969;
            color: #ffffff;
        }

        header a {
            text-decoration: none;
            color: #ffffff;
        }

        .top_right {
            float: right;
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
    </style>
</head>

<body>
    <!-- <header>
        <span>欢迎访问数字图书馆！</span>
        <div class='top_right'>
            <a href='login/login.php'>登录 </a> | <a href='register/register.php'> 注册</a>
        </div>
    </header> -->
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="../index.php"> <img alt="logo" class="logo" src="../images/logo.png" />
            </a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm"> <a href="../index.php">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm layui-this"> <a href="books_sort.php?id=1">文学类</a> </li>
                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort.php?id=2">冒险类</a> </li>
                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort.php?id=3">励志类</a> </li>
                <li class="layui-nav-item hc-hide-sm "> <a href="books_sort.php?id=4">历史类</a> </li>
                <li class="layui-nav-item hc-show-sm"> <a href="javascript:;">更多</a>
                    <dl class="layui-nav-child">
                        <dd class=""><a href="books_sort.php?id=5">玄幻类</a></dd>
                        <dd class=""><a href="books_sort.php?id=6">悬疑类</a></dd>
                        <dd class=""><a href="books_sort.php?id=7">政治类</a></dd>
                        <dd class=""><a href="books_sort.php?id=8">经济类</a></dd>
                        <dd class=""><a href="books_sort.php?id=9">军事类</a></dd>
                        <dd class=""><a href="books_sort.php?id=10">著作类</a></dd>
                    </dl>
                </li>
            </ul>

        </div>
    </nav>

    <div class="swiper-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="border: none;height: 550px;margin-top: 0;box-shadow: 0 0 0;">
                <img class="banner" src="../images/banner-1.png" />
            </div>
            <div class="swiper-slide" style="border: none;height: 550px;margin-top: 0;box-shadow: 0 0 0;">
                <img class="banner" src="../images/banner-2.png" />
            </div>
            <div class="swiper-slide" style="border: none;height: 550px;margin-top: 0;box-shadow: 0 0 0;">
                <img class="banner" src="../images/banner-3.png" />
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="books_recomend">
        <div>
            文学类图书书架
        </div>
    </div>

    <div class="footer" style="margin-top: 400px;">
        <div style="display: flex;justify-content: center;width: 100%;">
            <div style="display: flex;justify-content: space-between;width: 1200px;margin-top: 120px;">
                <div style="width: 240px;height: 130px;border-right: 1px solid #4B4B4B;">
                    <img src="img/logo-1.png" />
                    <a href="https://beian.miit.gov.cn/" target="_blank">
                        <p style="color: #C3C3C3;font-size: 14px;margin-top: 55px;">
                            滇ICP备19032937号-1
                        </p>
                    </a>
                </div>
                <div style="width: 320px;height: 130px;color: #C3C3C3;font-size: 14px;">
                    <p>
                        联系电话：<span style="font-size: 26px;color: #FFFFFF;">
                            0325-8888888
                        </span>
                    </p>
                    <p style="margin-top: 15px;">
                        公司邮箱：123456@gmail.com
                    </p>
                    <p style="margin-top: 15px;">
                        addressaddressaddressaddressaddress
                    </p>
                    <p style="margin-top: 15px;">
                        Jason xxx有限公司版权所有
                    </p>
                </div>
                <div style="width: 360px;height: 135px;">
                    <div style="height: 100px;">
                        <img src="img/Android-1.png" />
                        <img style="margin-left: 24px;" src="img/ios-1.png" />
                        <img style="margin-left: 24px;" src="img/xcx.png" />
                    </div>
                    <div style="height: 30px;color: #FFFFFF;font-size: 14px;margin-top: 14px;">
                        <span style="margin-left: 12px;">222222222</span>
                        <span style="margin-left: 58px;">555555</span>
                        <span style="margin-left: 58px;">22222211</span>
                    </div>
                </div>
                <div style="width: 180px;height: 130px;text-align: right;">
                    <a href="http://system.bjswz.cn/cmsx.html" target="_blank">
                        <img src="img/admin.png" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="menu">
        <div class="btn">
            <a href='../login/login.php'>登录 </a>
        </div>
        <div class="btn">
            <a href='../register/register.php'> 注册</a>
        </div>
        <img id="gotoTop" title="返回顶部" class="back" src="../images/gotop1.png" />
    </div>

    <script type="text/javascript" src="../js/layui.simple.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/swiper-bundle.min.js"></script>
    <script type="text/javascript">
        layui.extend({

        }).use(['element'], function() {

        });

        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-prev-1',
                prevEl: '.swiper-button-next-1',
            },
        });

        var swiper = new Swiper('.swiper-banner', {
            spaceBetween: 0,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
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

            // 获取页面的最小高度，无传入值则默认为600像素
            minHeight ? minHeight = minHeight : minHeight = 1080;

            // 为窗口的scroll事件绑定处理函数
            $(window).scroll(function() {
                // 获取窗口的滚动条的垂直滚动距离
                var s = $(window).scrollTop();

                // 当窗口的滚动条的垂直距离大于页面的最小高度时，让返回顶部图标渐现，否则渐隐
                // if( s > minHeight){
                //     $("#gotoTop").fadeIn(500);
                // }else{
                //     $("#gotoTop").fadeOut(500);
                // };
            });
        };
        gotoTop();
    </script>
</body>

</html>