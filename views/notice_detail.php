<?php
    /*
     * 公告，新闻二级页面
    */
    session_save_path('../session/');
    session_start(); //开启session
    include '../config/conn.php';
    include "../oauth/session_time.php";

    //获取全局变量用户名参数
    $user = $_SESSION['user'];

    // 获取url传过来的值id
    $url = $_SERVER["REQUEST_URI"];
    $array = parse_url($url);
    $id = substr($array['query'],3);

    //执行sql语句的查询语句
    $sql1 = "select * from news_notice where id='$id'";
    $result = mysqli_query($db_connect,$sql1);
    $row = mysqli_fetch_array($result);

    $hits = $row['see_num']+1;
    mysqli_query($db_connect, "update news_notice set see_num='$hits' where id='$id'");

    mysqli_close($db_connect);
?>
<!DOCTYPE html>
<html>

<head>
    <title>文章详情</title>
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

        .layui-main{
            width: 100%;
        }

        .layui-carousel{
            margin-top: 135px;
            height: 400px !important;
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
            padding: 50px 150px 80px 150px;
            display: flex;
        }

        .left_nav{
            width: 200px;
            border-top: 6px solid #429488;
            border-left: 8px solid #429488;
            padding: 0 10px 0 0;
            background-color: #fff;
        }

        .right_nav{
            width: calc(100% - 200px);
            padding: 0 20px;
        }

        .layui-menu li{
            padding: 10px 15px;
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
        <div class='top_right'>
            <?php
                if($user != ''){
                    echo "您好！$user &nbsp; &nbsp; <a href='../administrator/index'>后台 </a> &nbsp; | &nbsp; <a href='../oauth/logout'> 注销</a>";
                }else{
                    echo "<a href='../oauth/login'><i class='layui-icon layui-icon-username'></i> 登录 </a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="/"> <img alt="logo" class="logo" src="../skin/images/logo.png" /></a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm hc-hide-xs"> <a href="/">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">资源</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/book_center">馆藏资源</a></dd>
                        <dd><a href="../views/search_bookData">图书查询</a></dd>
                        <dd><a href="javascript:;">新书通报</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">服务</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/reader_center">借阅卡服务</a></dd>
                        <dd><a href="javascript:;">自助打印</a></dd>
                        <dd><a href="javascript:;">借阅指南</a></dd>
                        <dd><a href="javascript:;">图书捐赠</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm layui-this">
                    <a href="javascript:;">动态</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../views/notice_list#news">新闻资讯</a></dd>
                        <dd><a href="../views/notice_list#notice">通知公告</a></dd>
                        <dd><a href="javascript:;">活动信息</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">关于</a>
                    <dl class="layui-nav-child">
                        <dd><a href="https://mp.weixin.qq.com/s/ccWx9YN5-U2Ut3XDpwYq-w">图书馆简介</a></dd>
                        <dd><a href="https://mp.weixin.qq.com/s/eMThZAwR6I7PA-wPmRj8KQ">馆藏分布</a></dd>
                        <dd><a href="../views/about">开放时间</a></dd>
                        <dd><a href="javascript:;">常见问题</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-md hc-show-sm"> <a href="javascript:;">菜单</a>
                    <dl class="layui-nav-child">
                        <dd><a href="../index">首页</a></dd>
                        <dd><a href="../views/book_center">资源</a></dd>
                        <dd><a href="../views/reader_center">服务</a></dd>
                        <dd><a href="../views/notice_list">动态</a></dd>
                        <dd><a href="../views/about">关于</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </nav>

    <div class="layui-carousel" id="carousel">
        <div carousel-item>
            <div>
                <img class="banner" src="../skin/images/banner/sourece_banner.jpg" />
            </div>
        </div>
    </div>

    <div class="content">
        <div class="left_nav">
            <ul class="layui-menu" id="docDemoMenu1">
                <li lay-options="" class="layui-menu-item-checked">
                    <div class="layui-menu-body-title">
                        <a href="javascript:;">文章详情</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <li class="layui-menu-item-divider"></li>
                <li lay-options="">
                    <div class="layui-menu-body-title">
                        <a href="./notice_list#news">新闻资讯</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <li class="layui-menu-item-divider"></li>
                <li lay-options="">
                    <div class="layui-menu-body-title">
                        <a href="./notice_list#notice">通知公告</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <li class="layui-menu-item-divider"></li>
                <li lay-options="{id: 101}">
                    <div class="layui-menu-body-title">
                        <a href="javascript:;">活动信息</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="right_nav">
            <span class="layui-breadcrumb">
                <cite>当前位置： </cite>
                <a href="/">首页</a>
                <a href="./notice_list">动态</a>
                <a><cite>文章详情</cite></a>
            </span>
            <div style="color: #429488;font-size: 20px;padding: 15px 0;border-bottom: 4px solid #429488;">文章详情</div>
            <div style="padding: 30px 0;text-align: center">
                <div><h2><?php echo $row['title'] ?></h2></div>
                <div style="margin: 15px 0;">
                    <span style="color: #999;">
                        作者：<?php echo $row['author'] ?>&emsp;&emsp;
                        发布时间：<?php echo $row['sub_time'] ?>&emsp;&emsp;
                        浏览次数：<?php echo $row['see_num'] ?>
                    </span>
                </div>
                <hr style="border-bottom: 1px dashed #999 !important;margin: 5px 0 35px 0;">
                <article>
                    <?php echo $row['content'] ?>
                </article>
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
                        邮政编码：678000
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
                Copyright &copy; 2023.6 Jason Liu<a href="https://lib.crayon.vip" target="_blank" style="margin-left: 30px;">https://lib.crayon.vip</a>
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

        })
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
