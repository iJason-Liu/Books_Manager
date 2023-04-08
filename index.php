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
    <link rel="stylesheet" type="text/css" href="./skin/css/layui.css" />
    <link rel="stylesheet" href="./skin/css/modules/layer/layer.css">
    <link rel="stylesheet" type="text/css" href="./skin/css/index.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }

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
            padding-top: 5px;
        }

        .layui-nav * {
            font-size: 16px !important;
        }

        .search{
            width: 50%;
            height: 175px;
            border: none;
            border-top: 8px solid #429488;
            padding: 35px 55px;
            border-radius: 10px;
            background: #fff;
            opacity: .95;
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
            /*border: 1px solid;*/
            line-height: 55px;
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

        .captitle{
            line-height: 40px;
        }

        .books_recomend {
            width: 100%;
            height: 200px;
            border: 1px solid #000;
        }

        .content{
            margin-top: 80px;
            padding: 0 120px 80px 120px;
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
        <span>欢迎访问小新的主站！</span>
        <div class='top_right'>
            <!--<a href='./login/login.php'>登录 </a> &nbsp; | &nbsp; <a href='./register/register.php'> 注册</a>-->
            <?php
                if($user != ''){
                    echo "您好！$user &nbsp;&nbsp; <a href='./administrator/index.php'>后台 </a> &nbsp;|&nbsp; <a href='./login/logout.php'> 退出登录</a>";
                }else{
                    echo "<a href='./login/login.php'><i class='layui-icon layui-icon-username'></i> 登录 </a>";
                }
            ?>
        </div>
    </header>
    <nav class="layui-header hc-header">
        <div class="layui-main">
            <a class="hc-logo" href="./index.php"> <img alt="logo" class="logo" src="./skin/images/logo.png" />
            </a>
            <ul class="layui-nav">
                <li class="layui-nav-item hc-hide-sm layui-this"> <a href="./index.php">首页</a> </li>
                <li class="layui-nav-item hc-hide-sm"> <a href="./views/book_center.php">图书中心</a> </li>
                <li class="layui-nav-item hc-hide-sm"> <a href="./views/notice_list.php">图书资讯</a> </li>
                <li class="layui-nav-item hc-hide-sm"> <a href="./views/about.php">关于项目</a> </li>
                <li class="layui-nav-item hc-show-sm"> <a href="javascript:;">更多</a>
                    <dl class="layui-nav-child">
                        <dd><a href="./index.php">首页</a></dd>
                        <dd><a href="./views/book_center.php">图书中心</a></dd>
                        <dd><a href="./views/notice_list.php">图书资讯</a></dd>
                        <dd><a href="./views/about.php">关于项目</a></dd>
                        <!--<dd class=""><a href="">政治、法律</a></dd>-->
                        <!--<dd class=""><a href="">文学</a></dd>-->
                        <!--<dd class=""><a href="">历史、地理</a></dd>-->
                        <!--<dd class=""><a href="">经济</a></dd>-->
                        <!--<dd class=""><a href="">更多...</a></dd>-->
                    </dl>
                </li>
            </ul>
        </div>
    </nav>

    <div class="layui-carousel" id="carousel" style="position: unset;margin-top: 135px;">
        <div carousel-item>
            <div>
                <img class="banner" src="./skin/images/banner/banner_1.png" />
            </div>
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
                    <div class="layui-col-md2">
                        <a href="javascript:;">
                            <img width="48" height="48" src="./skin/images/other/book.png">
                            <div class="captitle">图书资源</div>
                        </a>
                    </div>
                    <div class="layui-col-md2">
                        <a href="javascript:;">
                            <img width="48" height="48" src="./skin/images/other/news.png">
                            <div class="captitle">图书资讯</div>
                        </a>
                    </div>
                    <div class="layui-col-md2">
                        <a href="javascript:;">
                            <img width="48" height="48" src="./skin/images/other/hot.png">
                            <div class="captitle">热门推荐</div>
                        </a>
                    </div>
                    <div class="layui-col-md2">
                        <a href="https://mp.weixin.qq.com/s/eMThZAwR6I7PA-wPmRj8KQ" target="_blank">
                            <img width="48" height="48" src="./skin/images/other/tag.png">
                            <div class="captitle">馆藏分布</div>
                        </a>
                    </div>
                    <div class="layui-col-md2">
                        <a href="https://mp.weixin.qq.com/s/ccWx9YN5-U2Ut3XDpwYq-w" target="_blank">
                            <img width="48" height="48" src="./skin/images/other/study.png">
                            <div class="captitle">图书馆简介</div>
                        </a>
                    </div>
                    <div class="layui-col-md2">
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
        <div class="books_recomend">
            <div class="r_title">推荐图书</div>
            <div>
                图书数据
            </div>
            <br>
            <p>
                <audio controls src="https://crayon.vip/audio/谁(Live版) - 廖俊涛.mp3"></audio>
            </p>
        </div>
        <div style="width: 100%;margin-top: 30px;border: 1px dashed;">
            <img style="width: 100%" src="./skin/images/前端示意图.png">
        </div>
    </div>

    <div class="layui-footer" style="text-align: center;background: #9f9f9f;padding: 10px;box-shadow: -1px 0 4px rgb(0 0 0 / 12%);">
        <p>
            Copyright ©  2023.6 Jason Liu &nbsp;&nbsp;<a href="https://www.crayon.vip">https://www.crayon.vip</a>
        </p>
        <br>
        <p>
            网站ICP备案号：<a href="https://beian.miit.gov.cn/" target="_blank">滇ICP备2023001154号-1</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="./skin/images/beian.png" alt="" style="margin-top: -3px;"/> 滇公网安备 53252702252753号</a>
        </p>
    </div>

    <img id="gotoTop" title="返回顶部" class="back" src="./skin/images/gotop.png" />

    <script type="text/javascript" src="./skin/js/layui.simple.js"></script>
    <script src="./skin/js/jquery-3.3.1.min.js"></script>
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
                            a.href = "./views/book_center.php?keywords="+keywords;
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
                    area: ['42%', '70%'],
                    shadeClose: true,
                    move: false,  //禁止拖动
                    content: './views/submit_feedback.php'
                })
            })
        })
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