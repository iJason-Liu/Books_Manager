<?php
    /*
     * 借阅图书关联的读者详情显示页面
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $card_id = $_GET['card_id'];  //借阅卡号
    //查询匹配的数据表，判断是哪一个表在用查出的数据显示内容
    $stu_sql = "select * from student where cardNo='$card_id'";
    $stu = mysqli_num_rows(mysqli_query($db_connect, $stu_sql));
    $tea_sql = "select * from teacher where cardNo='$card_id'";
    $tea = mysqli_num_rows(mysqli_query($db_connect, $tea_sql));
    $worker_sql = "select * from lib_worker where id='$card_id'";
    $worker = mysqli_num_rows(mysqli_query($db_connect, $worker_sql));
    $super_sql = "select * from super_admin where id='$card_id'";
    $super = mysqli_num_rows(mysqli_query($db_connect, $super_sql));

    if($stu == 1){
        $result = mysqli_query($db_connect,$stu_sql);
    }else if($tea == 1){
        $result = mysqli_query($db_connect,$tea_sql);
    }else if($worker == 1){
        $result = mysqli_query($db_connect,$worker_sql);
    }else if($super == 1){
        $result = mysqli_query($db_connect,$super_sql);
    }

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>读者详情</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link rel="stylesheet" type="text/css" href="../../skin/css/layui.min.css" />
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <script src="../../skin/js/layui.min.js"></script>
    <style>
        /*隐藏功能*/
        .show {
            display: block !important;
        }

        .hide {
            display: none !important;
        }
        #form_tab{
            width: 80%;
            padding: 10px 40px 0 5px;
            margin: 30px auto;
        }

        .color{
            background-color: #f5f5f5;
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
        document.onselectstart=function(){return false}
        //禁用复制、剪贴版
        document.onbeforecopy=function(){return false}
        //禁用文本框或者文本域中的文字被选中
        document.onselect=function(){return false;}
    </script>
</head>
	<body>
        <form class="layui-form">
        <?php
            while($row = mysqli_fetch_array($result)){
                $user_type = $row['user_type'];
        ?>
            <div id="form_tab">
                <div class="layui-form-item">
                    <label class="layui-form-label">借阅卡号:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" value="<?php echo $row['cardNo'].$row['id']; ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
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
                    <label class="layui-form-label">姓 名:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" value="<?php echo $row['name'].$row['username']; ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性 别:</label>
                    <div class="layui-input-block">
                        <?php
                            if($row['sex'] == '男'){
                                echo "<input type='radio' name='sex' value='男' title='男' checked>";
                                echo "<input disabled type='radio' name='sex' value='女' title='女'>";
                            }else{
                                echo "<input disabled type='radio' name='sex' value='男' title='男'>";
                                echo "<input type='radio' name='sex' value='女' title='女' checked>";
                            }
                        ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">联系电话:</label>
                    <div class="layui-input-block">
                        <input disabled type="tel" value="<?php echo $row['mobile'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($user_type == '图书管理员' || $user_type == '超级管理员') echo "hide";?>">
                    <label class="layui-form-label">学 院:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" value="<?php echo $row['department'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item <?php if ($user_type == '图书管理员' || $user_type == '超级管理员') echo "hide";?>">
                    <label class="layui-form-label"><?php if($user_type=='教师')echo '管理班级：';else echo '班级：'; ?></label>
                    <div class="layui-input-block">
                        <input disabled type="text" value="<?php echo $row['class'] ?>" class="layui-input color">
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </form>
    </body>
</html>
