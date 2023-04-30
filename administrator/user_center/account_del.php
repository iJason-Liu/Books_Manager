<?php
    /*
     * 用户账号注销
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }

    $usertype = $_SESSION['usertype']; //用户登录时的身份 = $_SESSION['usertype']; //用户登录时的身份

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
    }else{
        $check_sql = "select * from other_user where id=$id";
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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../../skin/css/layui.min.css">
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        #form_tab{
            font-size: 15px;
            width: 35%;
            padding: 10px;
            margin: 70px 90px;
        }

        .layui-form-label{
            width: 90px;
        }

        .color{
            background-color: #f5f5f5;
        }

        .layui-btn{
            width: 130px;
        }

        .warning{
            padding: 10px 15px 10px 30px;
            font-size: 15px;
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
            <a href="../index">
                <div class="layui-logo layui-bg-black">Library</div>
            </a>
            <!-- 头部区域（可配合layui 已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-hide-xs"><a href="../index">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../../index">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide">帮助文档</a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item layui-hide-xs layui-show-md-inline-block">
                    <a href="javascript:;">
                        <img src="<?php echo $_SESSION['avatar'] ?>" class="layui-nav-img">
                        <?php
                            echo "您好！". $_SESSION['user'];
                        ?>
                    </a>
                    <dl class="layui-nav-child layui-nav-child-c">
                        <?php
                            if($usertype != '超级管理员'){
                                echo "<dd><a href='../user_center/user_Info'>个人中心</a></dd>";
                            }
                        ?>
                        <dd><a href="../user_center/update_pwd">修改密码</a></dd>
                        <dd><a href="../../login/logout">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <?php include "../layouts/layout_side.php"; ?>

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
                        <input disabled type="text" name="name" value="<?php echo $row['username']=='' ? $row['name'] : $row['username'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span><?php echo $row['id']=='' ? '借阅卡号：' : '账 号：' ?></label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="id" value="<?php echo $row['id']=='' ? $row['cardNo'] : $row['id'] ?>" class="layui-input color">
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

    <script type="text/javascript" src="../../skin/js/layui.min.js"></script>
    <script type="text/javascript">
        layui.use(['layer', 'form'],function (){
            let $ = layui.jquery
                ,layer = layui.layer
                ,form = layui.form;

            $('#submit').on('click', function () {
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                // console.log(data);
                layer.prompt({
                    title: "<i class='layui-icon layui-icon-face-cry'></i> 请输入<span style='color: red;'>'我确定'</span>",
                    move: false
                },function(value, index, elem){
                    // console.log(value);
                    if(value == '我确定'){
                        $.ajax({
                            url: '../../controllers/user_center/del_check',
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
                                        time: 3000,
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
                                            location.href = "../../login/logout";
                                        }
                                    })
                                } else {
                                    layer.msg(res.msg, {
                                        icon: 7,
                                        shade: .2,
                                        time: 2000
                                    })
                                }
                            }
                        })
                        layer.close(index);
                    }else{
                        layer.msg('请输入我确定！',{
                            time: 1200
                        });
                    }
                })
            })
        })
    </script>
</body>

</html>