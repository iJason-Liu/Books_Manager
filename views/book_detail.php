<?php
    /*
     * 图书推荐和图书排行的二级页面，显示图书详情，评论，在线阅读
    */
    session_save_path('../session/');
    session_start(); //开启session
    include '../config/conn.php';
    include "../oauth/session_time.php";

    //获取全局变量用户名参数
    $user = $_SESSION['user'];
    $user_id = $_SESSION['user_id'];  //用户id

    // 获取url传过来的值id  图书编号
    $url = $_SERVER["REQUEST_URI"];
    $array = parse_url($url);
    $id = substr($array['query'],3);

    //执行sql语句的查询语句
    $sql1 = "select * from book_list where book_id='$id'";
    $result = mysqli_query($db_connect,$sql1);
    $row = mysqli_fetch_array($result);

    //点击一次浏览次数+1
    $hits = $row['click_num']+1;
    mysqli_query($db_connect, "update book_list set click_num='$hits' where book_id='$id'");

    //每次随机5条评论展示
    $sql2 = "select * from book_comment where book_id='$id' order by rand() limit 5";
    $comm_data = mysqli_query($db_connect,$sql2);

    mysqli_close($db_connect);
?>
<!DOCTYPE html>
<html>

<head>
    <title>图书详情</title>
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

        #comment{
            width: 98%;
            border: 1px solid #eee;
            padding: 10px;
            display: block;
            min-height: 180px;
            resize: vertical;
            border-radius: 3px;
        }

        #comment:hover{
            border: 1px solid #429488;
        }

        .show_comm{
            width: 100%;
            min-height: 60px;
            background-color: #fff;
            padding: 10px 0;
            border-radius: 3px;
        }

        .item{
            display: flex;
            justify-content: center;
            height: 24px;
            padding: 10px;
            border-radius: 3px;
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
            <marquee width=460 scrollamount=3 direction=left align=middle><script src="https://log.weiluge.com/tools/one/api.php"></script></marquee>
        </span>
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
                <li class="layui-nav-item hc-hide-sm layui-this">
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
                <li class="layui-nav-item hc-hide-sm">
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
                        <a href="javascript:;">图书详情</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <li class="layui-menu-item-divider"></li>
                <li lay-options="">
                    <div class="layui-menu-body-title">
                        <a href="./search_bookData">图书查询</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <li class="layui-menu-item-divider"></li>
                <li lay-options="">
                    <div class="layui-menu-body-title">
                        <a href="./book_center#hot">热门图书</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <li class="layui-menu-item-divider"></li>
                <li lay-options="{id: 101}">
                    <div class="layui-menu-body-title">
                        <a href="javascript:;">新书通报</a>
                        <i class="layui-icon layui-icon-right"></i>
                    </div>
                </li>
                <!--<li class="layui-menu-item-divider"></li>-->
                <!--<li class="layui-menu-item-group layui-menu-item-down" lay-options="{type: 'group'}">-->
                <!--    <div class="layui-menu-body-title">-->
                <!--        新书推荐-->
                <!--        <i class="layui-icon layui-icon-up"></i>-->
                <!--    </div>-->
                <!--    <ul>-->
                <!--        <li lay-options="{id: 1031}">-->
                <!--            <div class="layui-menu-body-title">-->
                <!--                茶花女-->
                <!--            </div>-->
                <!--        </li>-->
                <!--        <li lay-options="{id: 1032}">-->
                <!--            <div class="layui-menu-body-title">-->
                <!--                活着-->
                <!--            </div>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
            </ul>
        </div>
        <div class="right_nav">
            <span class="layui-breadcrumb">
                <cite>当前位置： </cite>
                <a href="/">首页</a>
                <a href="./book_center">馆藏资源</a>
                <a><cite>图书详情</cite></a>
            </span>
            <div style="color: #429488;font-size: 20px;padding: 15px 0;border-bottom: 4px solid #429488;">图书详情</div>
            <div style="display: flex;justify-content: space-around;flex-wrap: wrap;padding: 30px 0;width: 100%;">
                <div style="width: 30%;">
                    <img width="230" height="300" src="<?php echo $row['book_cover'] ?>">
                </div>
                <div style="width: 65%;font-size: 17px;display: flex;justify-content: space-between;flex-direction: column;">
                    <div><h2><?php echo $row['book_name'] ?></h2></div>
                    <div>
                        <span style="color: #999;">ISBN：</span>
                        <?php echo $row['ISBN'] ?>
                    </div>
                    <div>
                        <span style="color: #999;">作者：</span>
                        <?php echo $row['author'] ?>
                    </div>
                    <div>
                        <span style="color: #999;">出版社：</span>
                        <?php echo $row['publisher'] ?>
                    </div>
                    <div>
                        <span style="color: #999;">上架日期：</span>
                        <?php echo $row['create_date'] ?>
                    </div>
                    <div>
                        <span style="color: #999;">浏览次数：</span>
                        <?php echo $row['click_num'] ?>
                    </div>
                    <div>
                        <button class="layui-btn layui-btn-danger online_reader">在线阅读</button>
                        <button class="layui-btn do_borrow">我要借阅</button>
                    </div>
                </div>
            </div>
            <div style="width: 80px;border-bottom: 2px solid #ff5722;font-size: 18px;">内容简介</div>
            <div style="width: 100%;max-height: 210px;overflow: hidden;text-overflow: ellipsis;padding: 15px 0;">
                <?php echo $row['mark'] ?>
            </div>
            <!--评论显示区-->
            <div class="show_comm">
                <?php
                    while ($item = mysqli_fetch_array($comm_data)){

                ?>
                <div class="item">
                    <div class='layui-elip' style="width: calc(100% - 50px)"><?php echo $item['content'] ?></div>
                    <div style="width: 50px;text-align: right;cursor:pointer;display: flex;justify-content: space-around;"><img title="点赞" onclick="star(<?php echo $item['comment_id'] ?>)" width="24" height="24" src="../skin/images/other/zan.png"><div style="width: 50px;height:24px;display: flex;justify-content: center;flex-direction: column;"> <?php echo $item['star'] ?></div></div>
                </div>
                <?php
                    }
                ?>
            </div>
            <div style="margin: 30px 0 10px 0;color: #429488;font-size: 18px;"><i class="layui-icon layui-icon-edit"></i>发表书评</div>
            <span style="color: #999;"> "尊重他人、保持礼貌，用文明的语言交流，让评论成为建设性的讨论。"</span>
            <?php
                if($user_id == ''){
            ?>
            <article class="art" style="position: relative">
                <textarea disabled id="comment" placeholder="请输入评论"></textarea>
                <a href="../oauth/login?index=1&book_id=<?php echo $row['book_id'] ?>" class="layui-btn layui-btn-normal" style="position: absolute;top: 75px;left: 40%;">请登录或注册</a>
            </article>
            <div style="text-align: right;margin-top: 10px;">
                <button class="layui-btn layui-btn-disabled" id="release">发 表</button>
            </div>
            <?php
                }else{
            ?>
            <article class="art">
                <textarea id="comment" placeholder="请输入评论"></textarea>
            </article>
            <div style="text-align: right;margin-top: 10px;">
                <button class="layui-btn" id="release">发 表</button>
            </div>
            <?php
                }
            ?>
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

            // 在线阅读
            $('.online_reader').on('click',function (){
                <?php
                    if($user_id == ''){
                        echo "layer.msg('请先登录！',{icon:5,shade:.2,time:1500});";
                    }else{
                        // 查出源文件地址跳转
                        echo "layer.msg('该功能即将上线！',{icon:7,shade:.2,time:1500})";
                    }
                ?>
            })

            // 借阅
            $('.do_borrow').on('click',function (){
                <?php
                    if($user_id == ''){
                        echo "layer.msg('请先登录！',{icon:5,shade:.2,time:1500});";
                    }else{
                        echo "location.href='../../administrator/books_circulation/borrowBook'";
                    }
                ?>
            })

            // 发布评论
            $('#release').on('click',function (){
                let con = $('#comment').val();
                if(con === ''){
                    layer.msg('请输入内容！');
                    $('#comment').focus();
                    return false;
                }
                <?php
                    if($user_id != ''){
                ?>
                $.ajax({
                    url: '../../controllers/views/sub_comment',
                    type: 'POST',
                    data: {
                        comment: con,  //评论内容
                        user_id: <?php echo $user_id ?>,  //用户id
                        book_id: <?php echo $id ?>  //图书编号
                    },
                    dataType: 'json',
                    success: function (res) {
                        // console.log(res);
                        if (res.code === 200) {
                            layer.msg(res.msg, {
                                icon: 6,
                                shade: .2,
                                time: 2000
                            },function (){
                                location.reload();
                            })
                        }else {
                            layer.msg(res.msg, {
                                icon: 7,
                                shade: .2,
                                time: 1500
                            })
                        }
                    }
                })
                <?php
                    }
                ?>
            })
        })

        // 点赞
        function star(id){
            // console.log(id);  //评论id
            $.ajax({
                type: 'POST',
                url: '../../controllers/views/star',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (res) {
                    // console.log(res);
                    if (res.code === 200) {
                        console.log('点赞+1');
                    }
                }
            })
        }
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
