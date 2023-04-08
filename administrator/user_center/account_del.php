<?php
    /*
     * 用户账号注销
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $usertype = $_SESSION['usertype']; //用户登录时的身份 = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select type_id from user_type where usertype_name='$usertype'";
    $res = mysqli_query($db_connect, $check_sql);

    $id = $_SESSION['user_id']; //借阅卡号也是id
    $username = $_SESSION['user']; //用户名、姓名
    //执行sql语句的查询语句
    if($usertype == '学生'){
        $check_sql = "select * from student where cardNo=$id";
    }else if($usertype == '教师'){
        $check_sql = "select * from teacher where cardNo=$id";
    }else if($usertype == '图书管理员'){
        $check_sql = "select * from lib_worker where id=$id";
    }else if($usertype == '超级管理员'){
        $check_sql = "select * from super_admin where id=$id";
    }
    $result = mysqli_query($db_connect,$check_sql);

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <title>用户注销</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../../skin/css/layui.css">
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        /*隐藏功能*/
        .show {
            display: block !important;
        }

        .hide {
            display: none !important;
        }

        #form_tab{
            font-size: 15px;
            width: 32%;
            padding: 10px;
            margin: 70px 90px;
        }

        .color{
            background-color: #f5f5f5;
        }

        .layui-btn{
            width: 130px;
        }

        .warning{
            padding: 10px 10px 10px 58px;
            font-size: 14px;
        }
    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function () {
            return false;
        }
        //禁用浏览器右键点击事件
        document.oncontextmenu = function () {
            return false;
        }
        //禁止拖拽
        document.ondragstart = function () {
            return false
        }
        //禁止用户选中网页上的内容
        // document.onselectstart=function(){return false}
        //禁用复制剪贴版
        document.onbeforecopy = function () {
            return false
        }
        //禁用文本框或者文本域中的文字被选中
        // document.onselect=function(){return false;}
    </script>
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
        <a href="../index.php">
            <div class="layui-logo layui-bg-black">Library</div>
        </a>
        <!-- 头部区域（可配合layui 已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item layui-hide-xs"><a href="../index.php">后台首页</a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="../../index.php">前台首页</a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide.php">帮助中心<span class="layui-badge">1</span></a></li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide-xs layui-show-md-inline-block">
                <a href="javascript:;">
                    <img src="<?php echo $_SESSION['src'] ?>" class="layui-nav-img">
                    <?php
                        echo "您好！". $_SESSION['user'];
                    ?>
                </a>
                <dl class="layui-nav-child layui-nav-child-c">
                    <?php
                        if($usertype != '超级管理员'){
                            echo "<dd><a href='../user_center/user_Info.php'>个人中心</a></dd>";
                        }
                    ?>
                    <dd><a href="../user_center/update_pwd.php">修改密码</a></dd>
                    <dd><a href="../../login/logout.php">注销</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <?php
    while ($row = mysqli_fetch_array($res)) {
        $type_id = $row['type_id'];
        ?>
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-username"></i>&nbsp;个人中心</a>
                        <dl class="layui-nav-child">
                            <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <?php
                                if($type_id != 1004){
                                    echo "<dd><a href='../user_center/user_Info.php'><i class='layui-icon layui-icon-username'></i>&nbsp;我的信息</a></dd>";
                                }
                            ?>
                            <dd><a href="../user_center/update_pwd.php"><i class="layui-icon layui-icon-password"></i>&nbsp;修改密码</a></dd>
                            <dd class="layui-this"><a href="../user_center/account_del.php"><i class="layui-icon layui-icon-logout"></i>&nbsp;账号注销</a></dd>
                        </dl>
                    </li>

                    <!-- 判断身份为超级管理员时显示 -->
                    <li class="layui-nav-item
                            <?php
                    if ($type_id == 1004) {
                        echo "show";
                    } else {
                        echo "hide";
                    }
                    ?>">
                        <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>&nbsp;馆员中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../lib_worker/worker_list.php"><i class="layui-icon layui-icon-group"></i>&nbsp;馆员档案</a></dd>
                        </dl>
                    </li>

                    <!-- 学生、教师不显示 -->
                    <li class="layui-nav-item
                            <?php
                    if ($type_id == 1003 || $type_id == 1004) {
                        echo "show";
                    } else {
                        echo "hide";
                    }
                    ?>">
                        <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>&nbsp;读者中心</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../reader/reader_list.php"><i class="layui-icon layui-icon-group"></i>&nbsp;&nbsp;读者档案</a></dd>
                            <dd><a href="../reader/reader_kind.php"><i class="layui-icon layui-icon-cols"></i>&nbsp;&nbsp;读者类型</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-read"></i>&nbsp;图书管理</a>
                        <dl class="layui-nav-child">
                            <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd><a href="../books_source/book_list.php"><i class="layui-icon layui-icon-read"></i>&nbsp;馆藏图书</a></dd>
                            <dd><a href="../books_source/book_search.php"><i class="layui-icon layui-icon-search"></i>&nbsp;图书查询</a></dd>
                            <!-- 图书点击量，借阅次数 -->
                            <dd><a href="../books_source/rank_book.php"><i class="layui-icon layui-icon-praise"></i>&nbsp;人气图书</a></dd>
                            <?php
                                if ($type_id == 1003 || $type_id == 1004) {
                                    echo "<dd><a href='../books_source/book_kind.php'><i class='layui-icon layui-icon-form'></i>&nbsp;图书类别</a></dd>";
                                }
                            ?>
                            <!-- 包含查询，书库名，编号，位置 -->
                            <dd><a href="../books_source/book_stack.php"><i class="layui-icon layui-icon-diamond"></i>&nbsp;书库信息</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-template-1"></i>&nbsp;流通管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../books_borrow/borrow_status.php"><i class="layui-icon layui-icon-release"></i>&nbsp;图书借阅</a></dd>
                            <!-- 续借操作，每次完成续借时间推迟7天  -->
                            <dd><a href="../books_borrow/renewBook.php"><i class="layui-icon layui-icon-refresh"></i>&nbsp;图书续借</a></dd>
                            <dd><a href="../books_borrow/returnBook.php"><i class="layui-icon layui-icon-prev-circle"></i>&nbsp;图书归还</a></dd>
                        </dl>
                    </li>

                    <!-- 评论只允许管理员和超级管理员查看 -->
                    <li class="layui-nav-item
                            <?php
                    if ($type_id == 1003 || $type_id == 1004) {
                        echo "show";
                    } else {
                        echo "hide";
                    }
                    ?>">
                        <a href="javascript:;"><i class="layui-icon layui-icon-dialogue"></i>&nbsp;评论管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="../comment/comment_center.php"><i class="layui-icon layui-icon-reply-fill"></i>&nbsp;评论中心</a></dd>
                            <dd><a href="../comment/comment_control.php"><i class="layui-icon layui-icon-set-fill"></i>&nbsp;评论风控</a></dd>
                        </dl>
                    </li>

                    <!-- 仅超级管理员显示权限管理 -->
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-console"></i>&nbsp;系统维护</a>
                        <dl class="layui-nav-child">
                            <?php
                            if ($type_id == 1004) {
                                echo "<dd><a href='../system/rights_center.php'><i class='layui-icon layui-icon-tabs'></i>&nbsp;权限管理</a></dd>";
                                echo "<dd><a href='../system/feedBack.php'><i class='layui-icon layui-icon-survey'></i>&nbsp;意见反馈</a></dd>";
                            }
                            ?>
                            <dd><a href="../system/sysInfo.php"><i class="layui-icon layui-icon-about"></i>&nbsp;系统信息</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item"><a href="https://ymck.me" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;友情链接</a></li>
                    <li class="layui-nav-item"><a href="https://ruancang.net" target="_blank"><i class="layui-icon layui-icon-link"></i>&nbsp;友情链接</a></li>
                    <li class="layui-nav-item"><a href="https://www.qijishow.com" target="_blank"><i class="layui-icon layui-icon-util"></i>&nbsp;小工具</a></li>
                </ul>
            </div>
        </div>
        <?php
    }
    ?>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <form class="layui-form" lay-filter="form_data">
            <?php
                while($row = mysqli_fetch_array($result)){
            ?>
            <div id="form_tab">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓 名:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="name" value="<?php if($usertype == '超级管理员') echo $row['username'];else echo $row['name'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($usertype == '图书管理员' || $usertype == '超级管理员') echo "show"; else echo "hide";?>">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>账 号:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="id" value="<?php echo $row['id'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($usertype == '图书管理员' || $usertype == '超级管理员') echo "hide";?>">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>借阅卡号:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="cardNo" value="<?php echo $row['cardNo'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="warning">
                        <span style="color: #FF0000FF;">注意：注销该账号之后您将失去本网站的服务，无法再进行借阅，使用在线阅读等功能！</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 50px;">
                        <button type="button" class="layui-btn layui-btn-lg layui-btn-danger" name="submit" id="submit" value="注销账号">注销账号</button>
                    </div>
                </div>
            </div>
                <?php
                    }
                ?>
            </form>
        </div>


        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2023 by Jason Liu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../../skin/images/beian.png" alt=""/>滇ICP备2023001154号-1</a>
                <!-- <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>-->
            </p>
        </div>
    </div>

    <script type="text/javascript" src="../../skin/js/layui.simple.js"></script>
    <script>
        layui.use(['layer', 'form'],function (){
            let $ = layui.jquery
                ,layer = layui.layer
                ,form = layui.form;

            $('#submit').on('click', function () {
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                // console.log(data);
                layer.prompt({
                    formType: 0,
                    title: "请输入'我确定'"
                },function (index){
                    layer.closeAll(index);
                    $.ajax({
                        url: '../../controllers/user_center/del_check.php',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            if (res.code === 200) {
                                //显示自动关闭倒计秒数
                                layer.alert(res.msg, {
                                    btn: [],
                                    offset: '50px',
                                    time: 3 * 1000,
                                    success: function(layero, index){
                                        let timeNum = this.time/1000
                                            , setText = function(start){
                                                layer.title((start ? timeNum : --timeNum) + ' 秒后跳转', index);
                                            };
                                        setText(!0);
                                        this.timer = setInterval(setText, 1000);
                                        if(timeNum <= 0){
                                            clearInterval(this.timer);
                                        }
                                    },
                                    end: function(){
                                        clearInterval(this.timer);
                                        //跳转logout页面
                                        location.href = "../login/logout.php";
                                    }
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    time: 1500
                                })
                            }
                        }
                    })
                })
            })
        })
    </script>
</body>

</html>