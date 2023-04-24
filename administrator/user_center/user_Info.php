<?php
    /*
     * 用户基本信息
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }else if ($_SESSION['usertype'] === '超级管理员') {
        echo "<script>alert('非法访问！');history.back();</script>";
    }

    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $usertype = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select type_id from user_type where usertype_name='$usertype'";
    $res = mysqli_query($db_connect, $check_sql);

    $id = $_SESSION['user_id']; //借阅卡号 id
    $username = $_SESSION['user']; //用户名、姓名
    //执行sql语句的查询语句
    if($usertype == '学生'){
        $check_sql = "select * from student where cardNo=$id";
    }else if($usertype == '教师'){
        $check_sql = "select * from teacher where cardNo=$id";
    }else if($usertype == '图书管理员'){
        $check_sql = "select * from lib_worker where id=$id";
    }else if($usertype == '超级管理员'){
        echo "<script>alert('此模块暂未开放！');history.back();</script>";
    }
    $result = mysqli_query($db_connect,$check_sql);
    $res_user = mysqli_query($db_connect,$check_sql); //获取更新后的用户名

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <title>个人信息</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../../skin/css/layui.min.css">
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        /*隐藏功能*/
        .show {
            display: block !important;
        }

        .hide {
            display: none !important;
        }

        .layui-btn{
            width: 120px;
        }

        #form_tab{
            width: 40%;
            padding: 10px;
            margin: 30px 90px;
        }

        .color{
            background-color: #f5f5f5;
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
        document.onselectstart=function(){return false}
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
                <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide.php">帮助中心</a></li>
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
                                echo "<dd><a href='../user_center/user_Info.php'>个人中心</a></dd>";
                            }
                        ?>
                        <dd><a href="../user_center/update_pwd.php">修改密码</a></dd>
                        <dd><a href="../../login/logout.php">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <?php include "../layouts/layout_side.php"; ?>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <form class="layui-form" lay-filter="form_data" style="padding-bottom: 44px;">
            <?php
                while($row = mysqli_fetch_array($result)){
            ?>
            <div id="form_tab">
                <div class="layui-form-item <?php if ($usertype == '图书管理员') echo "show"; else echo "hide";?>">
                    <label class="layui-form-label">账 号:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="id" value="<?php echo $row['id'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($usertype == '图书管理员') echo "hide";?>">
                    <label class="layui-form-label">借阅卡号:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="cardNo" value="<?php echo $row['cardNo'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($usertype == '图书管理员') echo "hide";?>">
                    <label class="layui-form-label">借阅卡状态:</label>
                    <div class="layui-input-inline">
                        <?php
                            if($row['card_status'] == 0){
                                echo "<input disabled type='text' style='color: #429488;' value='正常' class='layui-input color'>";
                            }else{
                                echo "<input disabled type='text' style='color: #ff0000;' value='异常' class='layui-input color'>";
                            }
                        ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">借书数量:</label>
                    <div class="layui-input-inline">
                        <input disabled type="number" name="num" value="<?php echo $row['borrow_limit'] ?>" class="layui-input color">
                    </div>
                    <div class="layui-form-mid layui-word-aux">（单位：本）</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>姓 名:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="name" id="name" value="<?php echo $row['name'] ?>" placeholder="请输入姓名" lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">当前身份:</label>
                    <div class="layui-input-inline">
                        <?php
                            if($usertype == '图书管理员'){
                                echo "<input disabled type='text' name='usertype' value='图书管理员' class='layui-input color'>";
                            }else if($usertype == '学生'){
                                echo "<input disabled type='text' name='usertype' value='学生' class='layui-input color'>";
                            }else if($usertype == '教师'){
                                echo "<input disabled type='text' name='usertype' value='教师' class='layui-input color'>";
                            }
                        ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>性 别:</label>
                    <div class="layui-input-inline">
                        <?php
                            if($row['sex'] == '男'){
                                echo "<input type='radio' name='sex' value='男' title='男' checked>";
                                echo "<input type='radio' name='sex' value='女' title='女'>";
                            }else{
                                echo "<input type='radio' name='sex' value='男' title='男'>";
                                echo "<input type='radio' name='sex' value='女' title='女' checked>";
                            }
                        ?>
                    </div>
                </div>
                <div class="layui-form-item <?php if ($usertype == '图书管理员') echo "hide";?>">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>学 院:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="department" id="department" value="<?php echo $row['department'] ?>" placeholder="请输入学院" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($usertype == '图书管理员') echo "hide";?>">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span><?php if($usertype=='教师')echo '管理班级：';else echo '班级：'; ?></label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="class" id="class" value="<?php echo $row['class'] ?>" placeholder="请输入班级" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>联系电话:</label>
                    <div class="layui-input-block">
                        <input disabled type="tel" name="mobile" id="mobile" value="<?php echo $row['mobile'] ?>" placeholder="请输入联系电话" lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item hide" id="tip">
                    <div class="layui-input-block">
                        <span style="color: #ff0000;">注：带*的可以编辑修改！</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 20px;">
                        <button type="button" class="layui-btn layui-btn-normal" style="margin-top: 25px;" id="go"  value="修改信息">修改信息</button>
                        <button type="reset" class="layui-btn layui-btn-primary hide" id="reset"  value="重置">重 置</button>
                        <button type="button" class="layui-btn hide" name="submit" id="submit" lay-submit value="确定">确 定</button>
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

    <script src="../../skin/js/layui.min.js"></script>
    <script>
        layui.use(['layer', 'form'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,form = layui.form;

            $('#submit').on('click',function (){
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                let reg = /^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/; //电话号码正则
                if(!reg.test(data.mobile)){
                    layer.tips('手机号码输入不正确！', '#mobile',{
                        tips: [1,'#666'],
                        time: 2000
                    })
                }else {
                    $.ajax({
                        url: '../../controllers/user_center/submit_info.php',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            // form.render(); //无效
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    // icon: 1,
                                    time: 1500
                                }, function () {
                                    location.reload();
                                    // form.render();
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    time: 1500
                                }, function () {
                                    location.reload();
                                    // form.render(null,'test');
                                })
                            }
                        }
                    })
                }
            })
            // form.on('submit(form_data)', function(data){
                // console.log(data.field);
                // $.ajax({
                //     url: '../user_center/submit_info.php',
                //     type: 'POST',
                //     data: JSON.stringify(data.field),
                //     dataType: 'json',
                //     success: function (res){
                //         // console.log(res);
                //         if(res.code === 200){
                //             layer.msg(res.msg, {
                //                 // icon: 1,
                //                 time: 1500
                //             },function (){
                //                 form.render(null,'form_data');
                //             })
                //         }else{
                //             layer.msg(res.msg, {
                //                 icon: 7,
                //                 time: 1500
                //             },function (){
                //                 form.render(null,'test');
                //             })
                //         }
                //     }
                // })
                // return false;
            // })

            $('#go').click(function (){
                layer.load(3,{
                    content: 'loading',
                    shade: 0.2,
                    time: 1000,
                    success: function (){
                        $('#name').removeAttr('disabled');
                        $('#department').removeAttr('disabled');
                        $('#class').removeAttr('disabled');
                        $('#mobile').removeAttr('disabled');
                        setInterval(function (){
                            $('#tip').removeClass('hide');
                            $('#go').addClass('hide');
                            $('#reset').removeClass('hide');
                            $('#submit').removeClass('hide');
                        },1050)
                    }
                })
            })
        })
    </script>
</body>

</html>