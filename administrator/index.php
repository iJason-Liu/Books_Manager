<?php
    /*
     * 后台管理中心-大厅
     */
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    include '../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../login/login'</script>";
    }

    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     * 1005 校外人员
     * 1006 其他
     */
    //一级判断
    $usertype = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select * from user_type where usertype_name='$usertype'";
    $res = mysqli_query($db_connect, $check_sql);
    $row = mysqli_fetch_array($res);

    // 第二级判断，根据配的权限显示或隐藏功能
    $user_id = $_SESSION['user_id']; //用户id
    $rights_sql = "select * from rights where id='$user_id'";
    $rights_res = mysqli_query($db_connect, $rights_sql);
    $item = mysqli_fetch_array($rights_res);

    // echo mysqli_error($db_connect);
    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <title>后台系统管理大厅</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../skin/css/layui.min.css">
    <link rel="stylesheet" href="../skin/css/modules/layer/layer.css">
    <style>
        /*
        * 隐藏功能
         */
        .show{
            display: block !important;
        }
        .hide{
            display: none !important;
        }

        .layui-laydate{
            font-size: 15px;
            margin-top: 25px;
        }
        .laydate-set-ym span{
            font-size: 18px;
        }
        .laydate-theme-molv .layui-laydate-main{
            width: 720px;
            height: 410px;
        }
        .layui-laydate-content table{
            width: 700px;
            height: 345px;
        }
        .laydate-theme-grid .layui-laydate-content td>div {
            height: 52px;
            line-height: 40px;
        }
        .laydate-theme-grid .layui-laydate-content td .laydate-day-mark{
            height: 52px;
            line-height: 52px;
        }
        .laydate-theme-grid .layui-laydate-content td .laydate-day-mark::after {
            right: 6px;
            top: 8px;
            width: 6px;
            height: 6px;
        }
        .laydate-theme-grid .laydate-year-list > li {
            height: 57px;
            line-height: 57px;
        }
        #he-plugin-simple div{
            z-index: 9;
        }

        .captitle{
            line-height: 30px;
        }
    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function(){ return false;}
        //禁用浏览器右键点击事件
        document.oncontextmenu = function(){return false;}
        //禁止拖拽
        document.ondragstart=function(){return false}
        //禁止用户选中网页上的内容
        // document.onselectstart=function(){return false}
        //禁用复制剪贴版
        document.onbeforecopy=function(){return false}
        //禁用文本框或者文本域中的文字被选中
        // document.onselect=function(){return false;}
    </script>
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <a href="./index">
                <div class="layui-logo layui-bg-black">Library</div>
            </a>
            <!-- 头部区域（可配合layui 已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-hide-xs layui-this"><a href="./index">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../index">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="./system/help_guide">帮助文档</a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <!-- 右侧消息 -->
                <li class="layui-nav-item" lay-header-event="msg" lay-unselect>
                    <a href="javascript:;">
                        <!--<i class="layui-icon layui-icon-notice layui-font-18"></i><span class="layui-badge layui-badge-dot"></span>-->
                        通知消息<span class="layui-badge layui-hide"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs layui-show-md-inline-block">
                    <a href="javascript:;">
                        <img src="<?php echo $_SESSION['avatar'] ?>" class="layui-nav-img">
                        <?php
                            echo "您好！". $_SESSION['user'];
                        ?>
                    </a>
                    <dl class="layui-nav-child layui-nav-child-c">
                        <!-- <dd><a href="#" style="font-size:14px;">
                            身份：
                        </a></dd> -->
                        <?php
                            if($usertype != '超级管理员'){
                                echo "<dd><a href='./user_center/user_Info'>个人中心</a></dd>";
                            }
                        ?>
                        <dd><a href="./user_center/update_pwd">修改密码</a></dd>
                        <hr>
                        <dd><a href="../login/logout">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <div class = "layui-side layui-bg-black">
            <div class = "layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class = "layui-nav layui-nav-tree">
                    <li class = "layui-nav-item">
                        <a class = "" href = "javascript:;"><i class = "layui-icon layui-icon-username"></i>&nbsp;&nbsp;个人中心</a>
                        <dl class = "layui-nav-child">
                            <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <?php
                                if ($row['type_id'] != 1004) {
                                    echo "<dd><a href='./user_center/user_Info'><i class='layui-icon layui-icon-username'></i>&nbsp;&nbsp;我的信息</a></dd>";
                                }
                            ?>
                            <dd><a href = "./user_center/update_pwd"><i class = "layui-icon layui-icon-password"></i>&nbsp;&nbsp;修改密码</a></dd>
                            <dd><a href = "./user_center/account_del"><i class = "layui-icon layui-icon-logout"></i>&nbsp;&nbsp;账号注销</a></dd>
                        </dl>
                    </li>

                    <!-- 超级管理员时显示 -->
                    <li class = "layui-nav-item <?php if ($item['lib_worker'] == 1)echo "layui-show"; else echo "layui-hide"; ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-user"></i>&nbsp;&nbsp;馆员中心</a>
                        <dl class = "layui-nav-child">
                            <dd><a href = "./lib_worker/worker_list"><i class = "layui-icon layui-icon-group"></i>&nbsp;&nbsp;馆员档案</a></dd>
                        </dl>
                    </li>

                    <!-- 学生、教师不显示 -->
                    <li class = "layui-nav-item <?php if ($item['reader_list'] == 1 || $item['reader_kind'] == 1)echo "layui-show"; else echo "layui-hide"; ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-user"></i>&nbsp;&nbsp;读者中心</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['reader_list'] == 1){
                                    echo "<dd><a href = './reader/reader_list'><i class = 'layui-icon layui-icon-group'></i>&nbsp;&nbsp;读者档案</a></dd>";
                                }
                                if($item['reader_kind'] == 1){
                                    echo "<dd><a href = './reader/reader_kind'><i class = 'layui-icon layui-icon-cols'></i>&nbsp;&nbsp;&nbsp;读者类型</a></dd>";
                                }
                            ?>
                        </dl>
                    </li>

                    <li class = "layui-nav-item">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-read"></i>&nbsp;&nbsp;图书管理</a>
                        <dl class = "layui-nav-child">
                            <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd><a href = "./books_center/book_list"><i class = "layui-icon layui-icon-read"></i>&nbsp;&nbsp;馆藏图书</a></dd>
                            <dd><a href = "./books_center/book_search"><i class = "layui-icon layui-icon-search"></i>&nbsp;&nbsp;图书查询</a></dd>
                            <!-- 图书点击量，借阅次数 -->
                            <dd><a href = "./books_center/rank_book"><i class = "layui-icon layui-icon-praise"></i>&nbsp;&nbsp;人气图书</a></dd>
                            <?php
                                if ($item['book_kind'] == 1) {
                                    echo "<dd><a href='./books_center/book_kind'><i class='layui-icon layui-icon-form'></i>&nbsp;&nbsp;图书类别</a></dd>";
                                }
                            ?>
                            <!-- 包含查询，书库名，编号，位置 -->
                            <dd><a href = "./books_center/book_stack"><i class = "layui-icon layui-icon-diamond"></i>&nbsp;&nbsp;书库信息</a></dd>
                        </dl>
                    </li>
                    <li class = "layui-nav-item">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-template-1"></i>&nbsp;&nbsp;流通管理</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['borrowBook'] == 1) {
                                    echo "<dd><a href='./books_circulation/borrowBook'><i class='layui-icon layui-icon-release'></i>&nbsp;&nbsp;图书借阅</a></dd>";
                                }
                            ?>
                            <!-- 续借操作，每次完成续借时间推迟7天  -->
                            <dd><a href = "./books_circulation/renewBook"><i class = "layui-icon layui-icon-refresh"></i>&nbsp;&nbsp;图书续借</a></dd>
                            <dd><a href = "./books_circulation/returnBook"><i class = "layui-icon layui-icon-prev-circle"></i>&nbsp;&nbsp;图书归还</a></dd>
                            <?php
                                if ($item['record_search'] == 1) {
                                    echo "<dd><a href='./books_circulation/record_search'><i class='layui-icon layui-icon-search'></i>&nbsp;&nbsp;记录查询</a></dd>";
                                }
                            ?>
                            <dd><a href = "javascript:;"><i class = "layui-icon layui-icon-edit"></i>&nbsp;&nbsp;丢失登记</a></dd>
                        </dl>
                    </li>

                    <!-- 评论只允许管理员和超级管理员查看 -->
                    <li class = "layui-nav-item <?php if ($item['comment_center'] == 1 || $item['comment_control'] == 1 || $item['news_notice'] == 1)echo "layui-show"; else echo "layui-hide"; ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-dialogue"></i>&nbsp;&nbsp;评论管理</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['comment_center'] == 1){
                                    echo "<dd><a href = './comment/comment_center'><i class = 'layui-icon layui-icon-reply-fill'></i>&nbsp;&nbsp;评论中心</a></dd>";
                                }
                                if($item['news_notice'] == 1){
                                    echo "<dd><a href = './comment/news_notice'><i class = 'layui-icon layui-icon-speaker'></i>&nbsp;&nbsp;新闻公告</a></dd>";
                                }
                            ?>
                            <!--<dd class="--><?php //if($url=='comment_control')echo 'layui-this'; ?><!--"><a href = "../comment/comment_control"><i class = "layui-icon layui-icon-set-fill"></i>&nbsp;&nbsp;评论风控</a></dd>-->
                        </dl>
                    </li>

                    <!-- 仅超级管理员显示权限管理 -->
                    <li class = "layui-nav-item">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-console"></i>&nbsp;&nbsp;关于系统</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['rights_center'] == 1) {
                                    echo "<dd><a href='./system/rights_center'><i class='layui-icon layui-icon-tabs'></i>&nbsp;&nbsp;权限管理</a></dd>";
                                }
                                if ($item['feedBack'] == 1) {
                                    echo "<dd><a href='./system/feedBack'><i class='layui-icon layui-icon-survey'></i>&nbsp;&nbsp;意见反馈</a></dd>";
                                }
                            ?>
                            <dd><a href = "./system/sysInfo"><i class = "layui-icon layui-icon-about"></i>&nbsp;&nbsp;系统信息</a></dd>
                        </dl>
                    </li>

                    <li class = "layui-nav-item
                    <?php
                        if ($row['type_id'] == 1004)echo "layui-show"; else echo "layui-hide";
                    ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;调试链接</a>
                        <dl class = "layui-nav-child">
                            <dd><a href = "http://swz.crayon.vip/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;书丸子官网PC</a></dd>
                            <dd><a href = "http://m.swz.crayon.vip/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;书丸子官网WAP</a></dd>
                            <dd><a href = "http://43.139.94.135:1011/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;服务器root</a></dd>
                            <dd><a href = "http://chat.crayon.vip" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;WebScoketChat</a></dd>
                        </dl>
                    </li>
                    <li class = "layui-nav-item"><a href = "https://ymck.me" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;友情链接</a></li>
                    <li class = "layui-nav-item"><a href = "https://ruancang.net" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;友情链接</a></li>
                    <li class = "layui-nav-item"><a href = "https://www.qijishow.com" target = "_blank"><i class = "layui-icon layui-icon-util"></i>&nbsp;&nbsp;小工具</a></li>
                    <li class = "layui-nav-item"><a href = "javascript:;" id = "aircondition"><i class = "layui-icon layui-icon-util"></i>&nbsp;&nbsp;便携小空调</a></li>
                </ul>
            </div>
        </div>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <div class="container" style="display: flex;padding: 20px 20px 100px 20px;">
                <div style="width: 720px;">
                    <img width="730" height="170" src="../skin/images/banner.png" >
                    <div id="MyCalendar"></div>
                </div>
                <div style="width: 100%;border: 1px solid #9f9f9f;margin-left: 50px;border-radius: 4px;">
                    <div style="height: 50px;border-bottom: 1px solid #9f9f9f;padding: 5px 5px 5px 10px;">
                        <div style="float: left;line-height: 50px;"><h3>常用功能&nbsp;<i class="layui-icon layui-icon-triangle-r"></i></h3></div>
                        <div style="float: right;margin-top: 4px;">
                            <div id="he-plugin-simple"></div>
                        </div>
                        <script>
                            WIDGET = {
                              "CONFIG": {
                                "modules": "01234",
                                "background": "1",
                                "tmpColor": "FFFFFF",
                                "tmpSize": "16",
                                "cityColor": "FFFFFF",
                                "citySize": "16",
                                "aqiColor": "B6D7A8",
                                "aqiSize": "16",
                                "weatherIconSize": "24",
                                "alertIconSize": "0",
                                "padding": "10px 10px 10px 10px",
                                "shadow": "0",
                                "language": "auto",
                                "borderRadius": "3",
                                "fixed": "false",
                                "vertical": "center",
                                "horizontal": "left",
                                "key": "94c3f678025b4922a6b1ae124a356253"
                              }
                            }
                        </script>
                        <script src="https://widget.qweather.net/simple/static/js/he-simple-common.js?v=2.0"></script>
                    </div>
                    <div class="layui-row" style="padding: 7px;border-bottom: 1px solid #eee;">
                        <div class="layui-col-md3" style="text-align: center;width: 100px;">
                            <a href="books_center/book_search">
                                <img width="48" height="48" src="../skin/images/other/book_search.png">
                                <div class="captitle">馆藏查询</div>
                            </a>
                        </div>
                        <div class="layui-col-md3" style="text-align: center;width: 100px;">
                            <a href="./books_circulation/borrowBook">
                                <img width="48" height="48" src="../skin/images/other/add_book.png">
                                <div class="captitle">图书借阅</div>
                            </a>
                        </div>
                        <div class="layui-col-md3" style="text-align: center;width: 100px;">
                            <a href="./books_circulation/renewBook">
                                <img width="48" height="48" src="../skin/images/other/book_4.png">
                                <div class="captitle">图书续借</div>
                            </a>
                        </div>
                        <div class="layui-col-md3" style="text-align: center;width: 100px;">
                            <a href="./books_circulation/returnBook">
                                <img width="48" height="48" src="../skin/images/other/return_book.png">
                                <div class="captitle">图书归还</div>
                            </a>
                        </div>
                        <div class="layui-col-md3" style="text-align: center;width: 100px;">
                            <a href="./books_circulation/record_search">
                                <img width="48" height="48" src="../skin/images/other/book.png">
                                <div class="captitle">记录查询</div>
                            </a>
                        </div>
                    </div>
                    <div style="padding: 7px;">
                        <h3>未读消息&nbsp;<i class="layui-icon layui-icon-triangle-r"></i></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2023 by Jason Liu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.crayon.vip">https://www.crayon.vip</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../skin/images/beian.png" alt=""/>滇ICP备2023001154号-1</a>
                <!--<a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>-->
            </p>
        </div>
    </div>

    <script type="text/javascript" src="../skin/js/layui.min.js"></script>
    <script>
        layui.use(['layer', 'util', 'laydate'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,laydate = layui.laydate
                ,util = layui.util;

            let state;
            let msg = '';  //消息列表html元素
            let user_id = <?php echo $_SESSION['user_id']; ?>;  //用户id

            //页面加载时加载消息列表
            $(function (){
                getMsg();
            })

            //获取消息列表
            function getMsg(){
                $.ajax({
                    type: "POST",
                    url: '../../controllers/system/getMsg',
                    data: {
                        user_id: user_id
                    },
                    dataType: 'json',
                    success: function (res) {
                        // console.log(res);
                        state = res.state;  //未读消息的条数
                        let data = res.data;
                        $('.layui-badge').text(res.count); //动态获取消息数量
                        msg = '';
                        if(data.length === 0){
                            msg += "<div style='margin: 50px auto;text-align: center;color: #999;'><img src='../skin/images/no_msg.png' style='width: 180px;height: 150px;'><p>暂无消息</p></div>";
                        }else {
                            for (let i in data) {
                                let color = data[i].state === '0' ? '#333' : '#999';  //定义已读未读的状态颜色
                                msg += "<div class='msg' style='padding: 15px;border-bottom: 1px solid #ddd;cursor: pointer;'>" +
                                        // "<div>"+data[i].sender+"</div>" +
                                        "<div style='color: " + color + ";font-weight: 500;font-size: 15px;'>" + data[i].content + "</div>" +
                                        "<div style='margin-top: 15px;'>" +
                                        "<span style='color: #777;font-size: 12px;padding: 5px;background: #f3f4f7;border-radius: 4px;'>" + data[i].sender + "</span>" +
                                        "<span style='color: #999;position: absolute;right: 15px;'>" + data[i].createtime + "</span></div>" +
                                        "</div>";
                            }
                        }
                        //有未读消息时显示
                        if(state !== 0){
                            $('.layui-badge').removeClass('layui-hide');
                        }
                    }
                })
            }

            //头部事件
            util.event('lay-header-event', {
                //右侧通知消息事件
                msg: function(){
                    let index = layer.open({
                        title: "<i class='layui-icon layui-icon-notice'></i> 通知消息 <span style='font-size: 12px;margin-left: 10px;color: #999;cursor:pointer;' title='删除所有消息' class='clearMsg'>清空消息</span>",
                        type: 1,
                        area: ['28%', '92.7%'],
                        offset: ['7.3%', '72%'], //自定义右上角
                        // offset: 'rt', //右上角
                        // anim: 5,
                        shade: .1,  //.1
                        // shadeClose: true,
                        // closeBtn: 2,
                        move: false,  //禁止拖动
                        scrollbar: false, //禁用滚动条
                        content: msg,
                        success: function (){

                        },
                        end: function (){
                            //把消息全部设置成已读，上传ajax设置
                            $.ajax({
                                type: "POST",
                                url: '../../controllers/system/setMsgState',
                                data: {
                                    user_id: user_id,
                                    // msg_id: 1   //单条消息id
                                },
                                dataType: 'json',
                                success: function (res) {
                                    // console.log('消息全部已读');
                                }
                            })
                            //关闭窗口已读消息，再次添加隐藏样式
                            $('.layui-badge').addClass('layui-hide');
                            getMsg();  //重新获取消息列表
                            // if(state !== 0){  //不等于0时刷新也就是第一次打开时关闭刷新，以后无新消息不刷新
                            //     location.reload();
                            // }
                        }
                    })
                    //鼠标移上变色
                    $('.layui-layer-content .msg').mouseover(function (){
                        $(this).css('background-color', '#eaeaee');
                    }).mouseout(function (){
                        $(this).css('background-color', '#fff');
                    })

                    //清空所有消息
                    $('.clearMsg').on('click', function () {
                        $.ajax({
                            type: "POST",
                            url: '../../controllers/system/clearMsg',
                            data: {
                                user_id: user_id
                            },
                            success: function (res) {
                                layer.msg('消息已清空！', {
                                    time: 2000
                                }, function () {
                                    getMsg();
                                })
                                layer.close(index); //关闭窗口
                            }
                        })
                    })
                }
            })

            $('#aircondition').on('click', function (){
                layer.open({
                    title: '便携小空调',
                    type: 2,
                    anim: 2,
                    area: ['40%', '88%'],
                    shadeClose: true,
                    content: "https://ac.yunyoujun.cn"
                })
            })

            //日期面板
            laydate.render({
                elem: '#MyCalendar',
                theme: ['#429488', 'grid'],
                position: 'static',
                calendar: true,
                format: 'yyyy年MM月dd日',
                show: true,
                btns: ['now'],
                mark: {
                    '0-4-23': '读书日',  //每月某天
                },
                done: function(value, date, endDate){
                    if(date.month === 5 && date.date === 1){
                        layer.msg('今天是五一劳动节噢~')
                    }
                    if(date.month === 7 && date.date === 1){
                        layer.msg('今天是七一建党节噢~')
                    }
                    if(date.month === 10 && date.date === 1){
                        layer.msg('今天是十一国庆节噢~')
                    }
                    if(date.month === 4 && date.date === 23){
                        layer.msg('今天是世界读书日~')
                    }
                },
                change: function(value, date, endDate){
                  // layer.msg(value)
                }
            })

        })
    </script>
</body>

</html>