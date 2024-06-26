<?php
    /*
     * 用户更新密码
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../oauth/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }

    $usertype = $_SESSION['usertype']; //用户登录时的身份

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
    <title>修改密码</title>
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
            width: 40%;
            padding: 10px;
            margin: 45px 90px;
        }

        .color{
            background-color: #f5f5f5;
        }

        .layui-btn{
            width: 120px;
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
                <li class="layui-nav-item layui-hide-xs"><a href="../../upload/pdf/小新图书馆操作指南.pdf" target="_blank">操作指南</a></li>
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
                        <dd><a href="../../oauth/logout">注销</a></dd>
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
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span><?php echo $row['id']=='' ? '借阅卡号：' : '账 号：' ?></label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="id" value="<?php echo $row['id']=='' ? $row['cardNo'] : $row['id'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">姓 名:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="name" value="<?php echo $row['username']=='' ? $row['name'] : $row['username'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>密 码:</label>
                    <div class="layui-input-block">
                        <input type="password" name="pwd" id="pwd" placeholder="请输入新密码" lay-verType="tips" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>确认密码:</label>
                    <div class="layui-input-block">
                        <input type="password" name="pwd2" id="pwd2" placeholder="请再次输入密码"  lay-verType="tips" class="layui-input">
                    </div>
                    <!--<div class="layui-form-mid layui-word-aux">-->
                    <!--    <a title="显示" lay-event="showPwd" id="showPwd" href="javascript:;"><img style="width: 26px;height: 18px;" src="../images/seePwd.png" /></a>-->
                    <!--</div>-->
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 45px;">
                        <button type="reset" class="layui-btn layui-btn-primary" id="reset"  value="重置">重 置</button>
                        <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="确定">确 定</button>
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
    <script>
        layui.use(['layer', 'form'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                , form = layui.form;

            form.verify({
                //(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]  特殊字符
                //[\S]非空白字符
                //{6,12} 长度
                //(?=.*[A-Za-z]) 任意字母
                // reg_pwd: [
                //     /^(?=.*[A-Za-z])(?=.*\d)[\S]{6,12}$/,'密码必须6至12位，包含字母数字，不能包含空格！'
                // ]
            })

            $('#submit').on('click', function () {
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                // console.log(data);
                let pwd = data.pwd;
                let pwd2 = data.pwd2;
                let reg = /^(?=.*[A-Za-z])(?=.*\d)[\S]{6,12}$/;
                if(!reg.test(pwd)){
                    layer.tips('密码必须6至12位，包含字母数字且不能包含空格！', '#pwd',{
                        tips: [3,'#666'],
                        time: 2000
                    })
                }else if(pwd2 !== pwd){
                    layer.msg('两次密码输入不一致！', {
                        icon: 7,
                        // anim: 6, //抖动提示
                        shade: .2,
                        time: 1500
                    })
                }else{
                    let index = layer.load(3,{
                        content: 'loading',
                        shade: 0.2
                    })
                    $.ajax({
                        url: '../../controllers/user_center/update_pwd_check',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            layer.close(index);
                            // console.log(res);
                            if (res.code === 200) {
                                //显示自动关闭倒计秒数
                                layer.alert(res.msg, {
                                    btn: [],
                                    // offset: '20px',
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
                                        location.href = "../../oauth/logout";
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
                }
            })
        })
    </script>
</body>

</html>