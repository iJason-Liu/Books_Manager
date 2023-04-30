<?php
    /*
     * 图书搜索中心
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
    <title>图书查询中心🔍</title>
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

        .content{
            padding: 0 150px;
            margin: 75px 0;
        }

        .search_show{
            padding: 20px;
            background: #fff;
            border-radius: 4px;
        }

        #search{
            font-size: 16px;
            height: 50px;
            /*width: 16%;*/
            border-radius: 0 4px 4px 0;
            margin-left: -10px;
        }

        .show_list{
            border: 1px solid;
            margin-top: 20px;
        }

        .data_item{
            width: 100%;
            display: flex;
        }
        .data_img{

        }
        .data_img img{
            height: 150px;
            width: 110px;
            border-radius: 2px;
        }

        .data_content{
            width: 100%;
            padding: 10px 20px;
        }

        /*背景色 #808080  #736F6E #837E7C  */
        .layui-footer{
            width: 100%;
            text-align: center;
            background: linear-gradient(#999999,#808080);
            color: #222222;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
        }
        .layui-footer a:hover{
            color: #222222;
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
                    echo "您好！$user &nbsp; &nbsp; <a href='../administrator/index'>后台 </a> &nbsp; | &nbsp; <a href='../login/logout'> 注销</a>";
                }else{
                    echo "<a href='../login/login'><i class='layui-icon layui-icon-username'></i> 登录 </a>";
                }
            ?>
        </div>
    </header>

    <div class="content">
        <div class="layui-row">
            <div class="layui-col-md12 search_show">
                <div class="layui-form" lay-filter="form_data" >
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="margin-left: 0;width: 75%;">
                            <input style="height: 50px;border-radius: 0;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入关键词进行检索" class="layui-input">
                        </div>
                        <button class="layui-btn" id="search"><i class='layui-icon layui-icon-search'></i> 检 索</button>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block" style="margin-left: 0">
                            <input type="radio" name="type" value="书名" title="书名" checked="">
                            <input type="radio" name="type" value="作者" title="作者">
                            <input type="radio" name="type" value="ISBN" title="ISBN">
                            <input type="radio" name="type" value="出版社" title="出版社">
                            <input type="radio" name="type" value="图书类别" title="图书类别">
                        </div>
                    </div>
                </div>

                <!-- 显示列表 -->
                <div class="show_list">
                    <div class="data_item">
                        <div class="data_img">
                            <img src="../upload/bookCover/s237622.jpg">
                        </div>
                        <div class="data_content">
                            <div style="width: 100%;height: 20px;">
                                书名
                            </div>
                            <div style="width: 100%;height: 20px;">
                                简介
                            </div>
                            <div style="width: 100%;height: 20px;">
                                作者
                            </div>
                            <div style="width: 100%;height: 20px;">
                                出版社，出版日期
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-footer">
        <div class="layui-row">
            <div class="layui-col-md12">
                Copyright ©  2023.6 Jason Liu<a href="https://lib.crayon.vip" target="_blank" style="margin-left: 30px;">https://lib.crayon.vip</a>
            </div>
            <div class="layui-col-md12" style="margin-top: 10px;">
                网站ICP备案号：<a href="https://beian.miit.gov.cn/" target="_blank">滇ICP备2023001154号-1</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../skin/images/beian.png" alt="" style="margin-top: -3px;"/> 滇公网安备 53252702252753号</a>
            </div>
        </div>
    </div>

    <img id="gotoTop" title="返回顶部" class="back" src="../skin/images/gotop.png"/>

    <script src="../skin/js/layui.min.js"></script>
    <script src="../skin/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        layui.use(['layer'], function() {

        })
    </script>
    <script type="text/javascript">
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
