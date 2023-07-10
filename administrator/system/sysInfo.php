<?php
    /*
     * 系统相关信息
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../oauth/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $usertype = $_SESSION['usertype']; //用户登录时的身份

    $id = $_SESSION['user_id'];
    if($usertype == '学生'){
        $sql = "select * from student where cardNo = '$id'";
    }else if($usertype == '教师'){
        $sql = "select * from teacher where cardNo = '$id'";
    }else if($usertype == '图书管理员'){
        $sql = "select * from lib_worker where id = '$id'";
    }else if($usertype == '超级管理员'){
        $sql = "select * from super_admin where id = '$id'";
    }else{
        $sql = "select * from other_user where id = '$id'";
    }
    $info_res = mysqli_query($db_connect, $sql);

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>系统信息</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        .title{
            width: 90%;
            margin: 30px 0 0 60px;
            font-size: 20px;
            font-weight: bold;
            border: 1px solid #eee;
            height: 50px;
            line-height: 50px;
        }

        .content{
            margin: 0 0 30px 60px;
            width: 90%;
            border: 1px solid #eee;
            font-size: 15px;
            background: #fff;
            border-radius: 3px;
        }

        .content .layui-form-item div{
            line-height: 36px;
            color: #666;
            margin-left: 180px;
        }

        .layui-form-label{
            width: 110px;
            background: #fafafa;
            color: #999;
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
            <div class="title">&emsp;<i class="layui-icon layui-icon-about layui-font-20"></i> 系统信息</div>
            <?php while ($row = mysqli_fetch_array($info_res)){

            ?>
            <div class="layui-form content">
                <div class="layui-form-item" style="margin-top: 15px;">
                    <label class="layui-form-label">账 号：</label>
                    <div class="layui-input-block">
                        <?php echo $row['id']=='' ? $row['log_time'] : $row['id']; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名：</label>
                    <div class="layui-input-block">
                        <?php echo $row['name']=='' ? $row['username'] : $row['name']; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">登录时间：</label>
                    <div class="layui-input-block">
                        <?php echo $row['log_time']; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">登录IP：</label>
                    <div class="layui-input-block">
                        <?php echo $row['log_ip']; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">登录运营商：</label>
                    <div class="layui-input-block">
                        <?php echo $row['log_carrier'];?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">系统名称：</label>
                    <div class="layui-input-block">小新图书馆</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">系统版本：</label>
                    <div class="layui-input-block">
                        Version 1.0
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">运行环境：</label>
                    <div class="layui-input-block">
                        Linux-7.9 &emsp; Apache-2.4 &emsp; MySQL-5.7 &emsp; PHP-7.3 &emsp; Layui-2.7.6
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
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
</body>

</html>
