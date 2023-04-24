<?php
    /*
     * 网站前端首页
     */
    session_save_path('./session/');
    session_start(); //开启session
    include './login/session_time.php';

    //获取全局变量-用户名参数
    $user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>小新的主站</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="./skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <!--仅pc访问设置上一行代码，手机端显示设置下面两行代码-->
    <!--<meta name="viewport" content="width=device-width">-->
    <!--<meta name="viewport" content="width=750px,user-scalable=no">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="@Jason Liu">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="keywords" content="小新的主站，图书管理系统，PHP，MySQL">
    <meta name="description" content="基于PHP+MySQL开发的图书管理系统">
    <link rel="stylesheet" type="text/css" href="./skin/css/layui.min.css" />
    <link rel="stylesheet" href="./skin/css/modules/layer/layer.css">
    <link rel="stylesheet" type="text/css" href="./skin/css/index.css" />
    <link rel="stylesheet" type="text/css" href="./skin/css/swiper-bundle.min.css" />
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
            z-index: 99;
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

        .layui-select-title .layui-input{
            height: 55px;
            text-align: center;
        }
        .layui-form-select .layui-edge{
            right: 20px;
        }
        .layui-form-select dl{
            text-align: left;
            top: 50px;
        }

        .search{
            width: 50%;
            height: 175px;
            border: none;
            border-top: 8px solid #429488;
            padding: 35px 55px;
            border-radius: 10px;
            background: #fff;
            opacity: .98;
            position: relative;
            top: -72%;
            left: 21%;
        }
        #search{
            font-size: 16px;
            height: 55px;
            width: 16%;
            border-radius: 0 4px 4px 0;
        }
        .labtitle{
            width: 175px;
            height: 55px;
            color: #fff;
            background: #429488;
            border-radius: 10px 10px 0 0;
            text-align: center;
            position: absolute;
            top: -23%;
            left: 0;
            line-height: 55px;
            font-size: 16px;
        }
        .search_item{
            position: relative;
            top: 15%;
            width: 100%;
            height: 85px;
            line-height: 55px;
        }

        .captitle{
            line-height: 40px;
        }

        .books_recommend {
            width: 100%;
            position: relative;
        }

        .swiper-slide{
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .news_img .swiper-slide{
            margin-top: 0;
        }

         .hot_comment .swiper-slide{
             margin-top: -2px;
             margin-bottom: 0;
        }

         .swiper-slide img{
            border-radius: 4px;
            width: 100%;
            height: 100%;
        }

        /* 推荐图书*/
        .book_show{
            border-radius: 4px;
            width: 100%;
            height: 190px !important;
            transition: all 0.5s;
        }
        /*放大1.2倍*/
        .book_show:hover{
            transform: scale(1.1);
        }

        .layui-carousel{
            margin-top: 135px;
        }

        .swiper-button-next {
            top: 64% !important;
            width: 48px !important;
            height: 48px !important;
            opacity: .3;
        }

        .swiper-button-prev {
            top: 64% !important;
            width: 48px !important;
            height: 48px !important;
            opacity: .3;
        }

        .swiper-button-next{
            right: -12px !important;
        }
        .swiper-button-prev{
            left: -12px !important;
        }

        .content{
            padding: 80px 150px;
        }

        .biaotou{
            height: 75px;
            width:100%;
            border-bottom: 3px solid #429488;
            line-height: 75px;
        }

        .news{
            margin: 50px 0;
            width: 100%;
            /*height: 530px;*/
            /*border: 1px solid;*/
        }

        .news_title{
            font-size: 18px;
            color: #fff;
            position: absolute;
            bottom: 30px;
            left: 20px;
            width: 90%;
            z-index: 1;
        }

        .layui-tab-title{
            height: 50px;
        }
        .layui-tab-title li{
            line-height: 50px;
        }
        .layui-tab-card>.layui-tab-title .layui-this{
            background-color: #429488;
        }
        .layui-tab-title .layui-this{
            color: #fff;
        }
        .layui-tab-title .layui-this:after{
            content: none;
        }
        .layui-tab-card>.layui-tab-title .layui-this:after{
            border-width: 0;
        }
        .layui-tab-card>.layui-tab-title li{
            margin: 0;
        }

        .layui-tab-title li{
            border-radius: 2px;
            font-size: 18px;
            width: 50%;
            padding: 0;
        }

        .news_li{
            border-bottom: 1px dashed #C9C9C9;
            padding: 16px 0;
        }

        .news_li:hover{
            border-bottom: 1px dashed #429488;
        }

        .comment_show{
            width: 100%;
        }

        .comment_list{
            height: 80px;
            line-height: 80px;
            border-bottom: 1px solid #e5e5e5;
            border-top: 1px solid #e5e5e5;
            background: #fff;
        }

        .comment_logo img{
            width: 64px;
            height: 64px;
            border-radius: 50%;
        }
        .comment_logo{
            text-align: center;
            /*padding-left: 15px;*/
        }

        .comment_main{
            display: flex;
            flex-direction: column;
            line-height: 45px;
        }
        .comment_title{
            height: 30px;
        }
        .comment_content{
            height: 50px;
            color: #666;
        }
        .comment_date{
            text-align: right;
            padding-right: 15px;
        }
        .comment_date img{
            width: 26px;
            height: 26px;
            margin: -8px 5px 0 0;
        }
        .comment_date span{
            color: #666;
            width: 24px;
            display: inline-block;
        }
        .comment_adimg{
            width: 100%;
            height: 480px;
            border-radius: 4px;
            -webkit-user-drag: none;
        }

        /*小于等于1280*/
        @media (max-width: 1280px) {
            /*推荐图书放大*/
            .book_show{
                width: 100%;
                height: 130px !important;
            }
        }

        /*大于1280*/
        @media (min-width:1281px) and (max-width: 1825px) {
            .comment_adimg{
                width: 100%;
                height: 480px;
            }

            .book_show{
                width: 100%;
                height: 190px !important;
            }
        }
        /*大于等于1825*/
        @media (min-width: 1825px) {
            .comment_adimg{
                width: 80%;
                height: 480px;
            }

            .book_show{
                width: 100%;
                height: 275px !important;
            }
        }

        .database_show{
            width: 100%;
            margin: 50px 0;
        }

        .database{
            margin-top: 15px;
        }
        .database div{
            margin-top: 35px;
        }

        /*热门数据库图*/
        .data img{
            width: 75%;
            height: 60px;
            transition: all 0.5s;
            border: 1px dashed #fafafa;
        }

        /*放大1.2倍*/
        .data img:hover{
            transform: scale(1.2);
            border: 1px dashed #429488;
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
        <span>欢迎访问小新的主站！</span>
        <div class='top_right'>
            <!--<a href='./login/login.php'>登录 </a> &nbsp; | &nbsp; <a href='./register/register.php'> 注册</a>-->
            <?php
                if($user != ''){
                    echo "您好！$user &nbsp; &nbsp; <a href='./administrator/index.php'>后台</a> &nbsp; | &nbsp; <a href='./login/logout.php'>注销</a>";
                }else{
                    echo "<a href='./login/login.php'><i class='layui-icon layui-icon-username'></i> 登录 </a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="./index.php"> <img alt="logo" class="logo" src="./skin/images/logo.png" /></a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm hc-hide-xs layui-this"> <a href="./index.php">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">资源</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./views/book_center.php">馆藏资源</a></dd>
                        <dd><a href="./views/search_bookData.php" target="_blank">馆藏查询</a></dd>
                        <dd><a href="./views/new_book.php">新书通报</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">服务</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./views/reader_center.php">借阅卡服务</a></dd>
                        <dd><a href="javascript:;">自助打印</a></dd>
                        <dd><a href="javascript:;">借阅指南</a></dd>
                        <dd><a href="javascript:;">图书捐赠</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">动态</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./views/notice_list.php#news">新闻资讯</a></dd>
                        <dd><a href="./views/notice_list.php#notice">通知公告</a></dd>
                        <dd><a href="javascript:;">活动信息</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-sm">
                    <a href="javascript:;">关于</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./views/about.php">项目介绍</a></dd>
                        <dd><a href="https://mp.weixin.qq.com/s/ccWx9YN5-U2Ut3XDpwYq-w">图书馆介绍</a></dd>
                        <dd><a href="https://mp.weixin.qq.com/s/eMThZAwR6I7PA-wPmRj8KQ">馆藏分布</a></dd>
                        <dd><a href="javascript:;">开放时间</a></dd>
                        <dd><a href="javascript:;">常见问题</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item hc-hide-md hc-show-sm"> <a href="javascript:;">菜单</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./index.php">首页</a></dd>
                        <dd><a href="./views/book_center.php">资源</a></dd>
                        <dd><a href="./views/reader_center.php">服务</a></dd>
                        <dd><a href="./views/notice_list.php">动态</a></dd>
                        <dd><a href="./views/about.php">关于</a></dd>
                        <dd><a href="./register/register.php" target="_blank">Register</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </nav>

    <div class="layui-carousel" id="carousel">
        <div carousel-item>
            <!--<div>-->
            <!--    <img class="banner" src="./skin/images/banner/banner_1.png" />-->
            <!--</div>-->
            <div>
                <img class="banner" src="./skin/images/banner/banner_6.jpg" />
            </div>
            <div>
                <img class="banner" src="./skin/images/banner/banner_5.jpg" />
            </div>
            <div>
                <img class="banner" src="./skin/images/banner/banner_7.jpg" />
            </div>
            <div>
                <img class="banner" src="./skin/images/banner/banner_8.jpg" />
            </div>
        </div>
        <!--搜索-->
        <div class="search">
            <div class="layui-form" lay-filter="form_data" >
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 18%;padding: 0;">
                        <select name="keywords_type" lay-filter="keys">
                            <option value="0">书名</option>
                            <option value="1">作者</option>
                            <option value="2">ISBN</option>
                            <option value="3">出版社</option>
                        </select>
                    </label>
                    <div class="layui-input-inline" style="width: 66%;margin-right: 0;">
                        <input style="height: 55px;border-radius: 0;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入关键词进行检索" class="layui-input">
                    </div>
                    <button class="layui-btn" id="search"><i class='layui-icon layui-icon-search'></i> 检 索</button>
                </div>
            </div>
            <div class="labtitle">馆藏资源</div>
            <div class="search_item">
                <div class="layui-row" style="text-align: center;">
                    <div class="layui-col-md2 layui-col-sm2 layui-col-xs2">
                        <a href="https://mp.weixin.qq.com/s/ccWx9YN5-U2Ut3XDpwYq-w" target="_blank">
                            <img width="48" height="48" src="./skin/images/other/lib_1.png">
                            <div class="captitle">图书馆简介</div>
                        </a>
                    </div>
                    <div class="layui-col-md2 layui-col-sm2 layui-col-xs2">
                        <a href="https://mp.weixin.qq.com/s/eMThZAwR6I7PA-wPmRj8KQ" target="_blank">
                            <img width="48" height="48" src="./skin/images/other/site_2.png">
                            <div class="captitle">馆藏分布</div>
                        </a>
                    </div>
                    <div class="layui-col-md2 layui-col-sm2 layui-col-xs2">
                        <a href="./views/new_book.php" target="_blank">
                            <img width="48" height="48" src="./skin/images/other/book_4.png">
                            <div class="captitle">新书通报</div>
                        </a>
                    </div>
                    <div class="layui-col-md2 layui-col-sm2 layui-col-xs2">
                        <a href="./views/book_center.php#hot">
                            <img width="48" height="48" src="./skin/images/other/hot_recommend.png">
                            <div class="captitle">热门图书</div>
                        </a>
                    </div>
                    <div class="layui-col-md2 layui-col-sm2 layui-col-xs2">
                        <a href="./views/notice_list.php">
                            <img width="48" height="48" src="./skin/images/other/notice_2.png">
                            <div class="captitle">新闻&公告</div>
                        </a>
                    </div>
                    <div class="layui-col-md2 layui-col-sm2 layui-col-xs2">
                        <a href="javascript:;" class="sub_feedback">
                            <img width="48" height="48" src="./skin/images/other/advice.png">
                            <div class="captitle">意见建议</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="books_recommend">
            <div class="biaotou" style="line-height: 0;">
                <span style="position: absolute;left: 0;font-size: 22px;">
                    <img width="64" height="64" src="./skin/images/other/flag.png" >&nbsp;
                    推荐图书
                </span>
                <span style="position: absolute;right: 2px;top: 10%;">
                    <a href="javascript:;">查看更多 <i class="layui-icon layui-icon-right"></i></a>
                </span>
            </div>
            <div class="swiper rec_book" style="width: 90%;">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="./views/book_detail.php?id=10001" title="书名">
                            <img class="book_show" src="./upload/bookCover/book-default.gif">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:;">
                            <img class="book_show" src="./upload/bookCover/s29506438.jpg">
                            <!--<p>默认图书</p>-->
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:;">
                            <img class="book_show" src="./upload/bookCover/s29260063.jpg">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:;">
                            <img class="book_show" src="./upload/bookCover/sampling.webp">
                        </a>
                    </div>
                     <div class="swiper-slide">
                        <a href="javascript:;">
                            <img class="book_show" src="./upload/bookCover/s237622.jpg">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:;">
                            <img class="book_show" src="./upload/bookCover/s123452.jpg">
                        </a>
                    </div>
                </div>
            </div>
            <img class="swiper-button-next" src="./skin/images/next.png" />
            <img class="swiper-button-prev" src="./skin/images/prev.png" />
        </div>
        <div class="news">
            <div class="biaotou">
                <span style="font-size: 22px;">
                    <img width="52" height="52" src="./skin/images/other/notice_1.png" >&nbsp;
                    新闻动态
                </span>
                <div style="float: right;">
                    <a href="./views/notice_list.php" target="_blank">查看更多 <i class="layui-icon layui-icon-right"></i></a>
                </div>
            </div>
            <div class="layui-row layui-col-space15" style="padding: 40px 30px 10px 30px;">
                <div class="layui-col-md6">
                    <div class="swiper news_img" style="width: 100%;height: 420px;">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="./views/notice_detail.php?id=1001" target="_blank">
                                    <img src="./skin/images/photo_wall/IMG_0217.JPG">
                                </a>
                                <span class="news_title layui-elip">
                                    这里是新闻公告标题，关于这个问题我们开始讨论
                                </span>
                            </div>
                            <div class="swiper-slide">
                                <a href="javascript:;">
                                    <img src="./skin/images/photo_wall/IMG_0218.JPG">
                                </a>
                            </div>
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0219.png">-->
                            <!--    </a>-->
                            <!--</div>-->
                            <div class="swiper-slide">
                                <a href="javascript:;">
                                    <img src="./skin/images/photo_wall/IMG_0220.JPG">
                                </a>
                                <span class="news_title layui-elip">
                                    新闻公告标题，同上一样开始讨论
                                </span>
                            </div>
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0222.png">-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0228.JPG">-->
                            <!--    </a>-->
                            <!--</div>-->
                             <div class="swiper-slide">
                                <a href="javascript:;">
                                    <img src="./skin/images/photo_wall/IMG_0223.png">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="javascript:;">
                                    <img src="./skin/images/photo_wall/IMG_0224.png">
                                </a>
                            </div>
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0225.png">-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0226.jpg">-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0228.JPG">-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0229.png">-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="swiper-slide">-->
                            <!--    <a href="javascript:;">-->
                            <!--        <img src="./skin/images/photo_wall/IMG_0234.png">-->
                            <!--    </a>-->
                            <!--</div>-->
                        </div>
                        <!--<div class="swiper-button-next"></div>-->
                        <!--<div class="swiper-button-prev"></div>-->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-tab layui-tab-card" style="border-radius: 6px;margin: 0;">
                          <ul class="layui-tab-title">
                            <li class="layui-this">新闻资讯</li>
                            <li>通知公告</li>
                          </ul>
                          <div class="layui-tab-content" style="height: 339px;padding: 12px 20px;">
                                <div class="layui-tab-item layui-show">
                                    <div class="news_li layui-row">
                                        <a href="./views/notice_detail.php?id=1002" target="_blank" title="标题">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                新闻标题1
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-02
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                新闻标题2
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-02
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                新闻标题3
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-02
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                新闻标题4
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-03-16
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                新闻标题5
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-02
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                新闻标题6
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-01
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-tab-item">
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                入馆须知
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-09
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                系统通知
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-08
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                图书馆开馆时间
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-01
                                        </div>
                                    </div>
                                    <div class="news_li layui-row">
                                        <a href="javascript:;">
                                            <div class="layui-col-md8 layui-col-sm8 layui-col-xs8 layui-elip" style="font-size: 16px;">
                                                借书指南
                                            </div>
                                        </a>
                                        <div class="layui-col-md4 layui-col-sm4 layui-col-xs8" style="text-align: right;color: #429488;">
                                            2023-04-03
                                        </div>
                                    </div>
                                </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="comment_show">
            <div class="biaotou">
                <span style="font-size: 22px;">
                    <img width="52" height="52" src="./skin/images/other/comment_2.png" >&nbsp;
                    精选评论
                </span>
            </div>
            <div class="layui-row layui-col-space30" style="margin-top: 30px;">
                <div class="layui-col-md8 layui-col-xs8">
                    <div class="swiper hot_comment" style="width: 100%;height: 480px;border-radius: 6px;">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2 layui-col-sm3 comment_logo">
                                        <img style="" src="./skin/images/avatar/IMG_0201.png">
                                    </div>
                                    <div class="layui-col-md8 layui-col-sm7 comment_main">
                                        <div class="comment_title">读者xx</div>
                                        <div class="layui-elip comment_content">策划书hi晒回事啊还快i哈卡还上课一看还可上半身啊深V计划获奖噶事。</div>
                                    </div>
                                    <div class="layui-col-md2 layui-col-sm2 comment_date">
                                        <img src="./skin/images/zan.png"><span>2236</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2 layui-col-sm3 comment_logo">
                                        <img style="" src="./skin/images/avatar.png">
                                    </div>
                                    <div class="layui-col-md8 layui-col-sm7 comment_main">
                                        <div class="comment_title">读者xxx</div>
                                        <div class="layui-elip comment_content">道阻且长，行则将至。</div>
                                    </div>
                                    <div class="layui-col-md2 layui-col-sm2 comment_date">
                                        <img src="./skin/images/zan.png"><span>82</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2 layui-col-sm3 comment_logo">
                                        <img style="" src="./skin/images/avatar/IMG_0208.PNG">
                                    </div>
                                    <div class="layui-col-md8 layui-col-sm7 comment_main">
                                        <div class="comment_title">读者小华</div>
                                        <div class="layui-elip comment_content">你是人间四月天。</div>
                                    </div>
                                    <div class="layui-col-md2 layui-col-sm2 comment_date">
                                        <img src="./skin/images/zan.png"><span>262</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2" style="text-align: center;">
                                        <img style="width: 64px;height: 64px;border-radius: 50%;" src="./skin/images/avatar/IMG_0204.PNG">
                                    </div>
                                    <div class="layui-col-md8">
                                        <span>评论者4</span>
                                        <span>内容</span>
                                    </div>
                                    <div class="layui-col-md2" style="text-align: center;">
                                        2023-03-28
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2" style="text-align: center;">
                                        <img style="width: 64px;height: 64px;border-radius: 50%;" src="./skin/images/avatar/IMG_0206.PNG">
                                    </div>
                                    <div class="layui-col-md8">
                                        <span>评论者3</span>
                                        <span>内容</span>
                                    </div>
                                    <div class="layui-col-md2" style="text-align: center;">
                                        2023-03-28
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2" style="text-align: center;">
                                        <img style="width: 64px;height: 64px;border-radius: 50%;" src="./skin/images/avatar/IMG_0209.JPG">
                                    </div>
                                    <div class="layui-col-md8">
                                        <span>评论者2</span>
                                        <span>内容</span>
                                    </div>
                                    <div class="layui-col-md2" style="text-align: center;">
                                        2023-03-28
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide comment_list">
                                <div class="layui-row">
                                    <div class="layui-col-md2" style="text-align: center;">
                                        <img style="width: 64px;height: 64px;border-radius: 50%;" src="./skin/images/avatar/IMG_0210.PNG">
                                    </div>
                                    <div class="layui-col-md8">
                                        <span>评论者1</span>
                                        <span>内容</span>
                                    </div>
                                    <div class="layui-col-md2" style="text-align: center;">
                                        2023-03-28
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md4 layui-col-xs4">
                    <img class="comment_adimg" src="./upload/bookCover/s29506438.jpg">
                </div>
            </div>
        </div>
        <div class="database_show">
            <div class="biaotou">
                <span style="font-size: 22px;">
                    <img width="52" height="52" src="./skin/images/other/database.png" >&nbsp;
                    常用数据库
                </span>
            </div>
            <div class="layui-row layui-col-space5 database" style="text-align: center;">
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="https://www.cnki.net/" target="_blank"><img src="./skin/images/database/cnki.jpeg" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="https://www.wanfangdata.com.cn/" target="_blank"><img src="./skin/images/database/wf.png" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="http://www.cqvip.com/" target="_blank"><img src="./skin/images/database/wp.gif" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="https://discovery.cass.cn/primo-explore/search?vid=cass&lang=zh_CN" target="_blank"><img src="./skin/images/database/zyfx.png" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="http://qikan.cqvip.com/" target="_blank"><img src="./skin/images/database/wpchinese.png" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="https://www.nstl.gov.cn/" target="_blank"><img src="./skin/images/database/gjkjwx.jpeg" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="https://www.duxiu.com/" target="_blank"><img src="./skin/images/database/cxdx.jpeg" /></a>
                </div>
                <div class="layui-col-md3 layui-col-sm4 layui-col-xs4 data">
                    <a href="https://qikan.chaoxing.com/" target="_blank"><img src="./skin/images/database/cxqk.png" /></a>
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
                <a href="https://lib.crayon.vip"><img width="98" height="98" src="./skin/images/qrcode.png"></a>
            </div>
        </div>
        <hr class="footer_hr">
        <div class="layui-row">
            <div class="layui-col-md12">
                Copyright &copy; 2023.6 Jason Liu<a href="https://lib.crayon.vip" target="_blank" style="margin-left: 30px;">https://lib.crayon.vip</a>
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

    <img id="gotoTop" title="返回顶部" class="back" src="./skin/images/gotop.png" />

    <script type="text/javascript" src="./skin/js/layui.min.js"></script>
    <script src="./skin/js/jquery-3.3.1.min.js"></script>
    <script src="./skin/js/swiper-bundle.min.js"></script>
    <script type="text/javascript">
        layui.use(['carousel', 'layer', 'form'], function() {
            let carousel = layui.carousel
                ,$ = layui.jquery
                ,layer = layui.layer
                ,form = layui.form;

            // 渲染轮播组件
            carousel.render({
                elem: '#carousel',
                width: '100%', //设置容器宽度
                height: '520px',
                arrow: 'hover', //显示箭头  none
                interval: 3500,
                anim: 'fade', //切换动画方式
                indicator: 'none'  //切换指标 inside
            })

            //搜索图书
            function search(){
                let data = form.val('form_data');
                // console.log(data);
                let keywords = $.trim(data.keywords);
                // console.log(keywords);
                if(keywords === ''){
                    layer.msg('请先输入关键词！',{
                        time: 1500
                    })
                }else {
                    //携带参数跳转
                    layer.load(3,{
                        content: 'loading',
                        shade: 0.2,
                        time: 1500,
                        success: function (){
                            let a = document.createElement('a');  //创建a标签
                            a.target = '_blank';  //在新页面打开
                            a.href = "./views/search_bookData.php?keywords="+keywords;
                            setTimeout(function (){
                                a.click();
                            }, 1650)
                        }
                    })
                }
            }
            //点击按钮搜索
            $('#search').on('click', function (){
                search();
            })

            //绑定enter回车搜索
            $(document).keyup(function (event) {
                if (event.keyCode == '13') {
                    search();
                }
            })

            //切换搜索类型时清除
            form.on("select(keys)",function(value){
                $('#key').val('');
            })

            //提交意见反馈
            $('.sub_feedback').on('click', function (){
                layer.open({
                    title: '<i class="layui-icon layui-icon-survey" style="margin-bottom: -2px;"></i> 用户反馈',
                    type: 2,
                    area: ['32%', '400px'],
                    shadeClose: true,
                    scrollbar: false,
                    move: false,  //禁止拖动
                    content: './views/submit_feedback.php'
                })
            })
        })
    </script>
    <script type="text/javascript">
        //推荐图书轮播
        new Swiper('.rec_book', {
            slidesPerView: 6,
            spaceBetween: 40,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        })

        //新闻轮播
        new Swiper('.news_img', {
            slidesPerView: 1,
            spaceBetween: 30,
            lazy: true,  //懒加载
            grabCursor: true,  //抓手
            // mousewheel: true,  //鼠标滚轮
            loop: true,   //循环
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // }
        })

        //热评垂直滚动
        new Swiper('.hot_comment', {
            slidesPerView: 6,
            spaceBetween: 0,
            direction: "vertical",
            loop: true,
            autoplay: {
                delay: 5000,
            }
        })

        //pv
        let i = 0;
        $('.visitor').text('1011');

        function gotoTop(minHeight) {
            // 定义点击返回顶部图标后向上滚动的动画
            $("#gotoTop").click(function() {
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