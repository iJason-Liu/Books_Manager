<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $id = $_GET['id'];
    $user_type = $_GET['user_type'];
    //执行sql语句的查询语句
    if ($user_type == '学生'){
        $sql1 = "select * from student where cardNo=$id";
    }else if($user_type == '教师'){
        $sql1 = "select * from teacher where cardNo=$id";
    }
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>修改读者信息</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link rel="stylesheet" type="text/css" href="../css/layui.css" />
    <link rel="stylesheet" type="text/css" href="../css/modules/layer/layer.css" />
    <style>
        #form_tab{
            width: 72%;
            padding: 10px 40px 40px 20px;
            margin: 35px auto;
        }

        .layui-btn{
            width: 120px;
        }

        .color{
            background-color: #f5f5f5;
        }

    </style>
</head>
	<body>
        <form class="layui-form" lay-filter="form_data">
            <?php
                while($row = mysqli_fetch_array($result)){
            ?>
            <div id="form_tab">
                <div class="layui-form-item">
                    <label class="layui-form-label">借阅卡号:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="id" id="id" value="<?php echo $row['cardNo'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>姓 名:</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" id="name" value="<?php echo $row['name'] ?>" placeholder="请输入姓名" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密 码:</label>
                    <div class="layui-input-block">
                        <input type="text" name="pwd" id="pwd" placeholder="请输入密码" value="<?php echo $row['password'] ?>" class="layui-input">
                    </div>
    <!--                <div class="layui-form-mid layui-word-aux">https://www.somd5.com/</div>-->
                </div>
                <div class="layui-form-item">
                        <div class="layui-input-block">
                            <span style="color: #ff0000;">解密点击：<a href="https://www.somd5.com" target="_parent_blank">https://www.somd5.com</a></span>
                        </div>
                    </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性 别:</label>
                    <div class="layui-input-block">
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
                <input type="hidden" name="user_type" placeholder="读者类型" value="<?php echo $row['user_type'] ?>">
                <div class="layui-form-item">
                    <label class="layui-form-label">学院:</label>
                    <div class="layui-input-block">
                        <input type="text" name="department" id="department" placeholder="请输入学院" value="<?php echo $row['department'] ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">所属班级:</label>
                    <div class="layui-input-block">
                        <input type="text" name="class" id="class" placeholder="请输入班级" value="<?php echo $row['class'] ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">联系电话:</label>
                    <div class="layui-input-block">
                        <input type="tel" name="mobile" id="mobile" placeholder="请输入联系电话" value="<?php echo $row['mobile'] ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">借书数量:</label>
                    <div class="layui-input-block">
                        <input type="number" name="limit" id="limit" placeholder="请输入可借图书数量" value="<?php echo $row['borrow_limit'] ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 50px;">
                        <button type="reset" class="layui-btn layui-btn-primary" value="重置">重 置</button>
                        <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="提交">提 交</button>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </form>

        <script src="../js/layui.simple.js"></script>
        <script>
            layui.use(['layer', 'form'], function() {
                let $ = layui.jquery
                    ,layer = layui.layer
                    ,form = layui.form;

                $('#submit').on('click',function (){
                    let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    let reg = /^(?=.*[A-Za-z])(?=.*\d)[\S]{6,12}$/; //密码正则
                    let reg2 = /^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/; //电话号码正则
                    if(data.name === ''){
                        layer.tips('姓名不能为空！', '#name',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    } else if(!reg.test(data.pwd)){
                        layer.tips('密码必须6至12位，包含字母数字，不能包含空格！', '#pwd',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    } else if(data.department === ''){
                        layer.tips('请输入学院！', '#department',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    }else if(data.class === ''){
                        layer.tips('请输入班级！', '#class',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    }else if(!reg2.test(data.mobile)){
                        layer.tips('手机号码输入不正确！', '#mobile',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    }else {
                        $.ajax({
                            url: '../reader/update_reader_check.php',
                            type: 'POST',
                            data: JSON.stringify(data),
                            dataType: 'json',
                            success: function (res) {
                                // console.log(res);
                                if (res.code === 200) {
                                    layer.msg(res.msg, {
                                        // icon: 1,
                                        time: 1500
                                    }, function () {
                                        parent.layui.table.reload('dataList'); //刷新父级窗口的table数据
                                        //关闭当前的iframe窗口
                                        let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                        parent.layer.close(index); //再执行关闭
                                    })
                                } else {
                                    layer.msg(res.msg, {
                                        icon: 7,
                                        time: 1500
                                    }, function () {
                                        //关闭当前的iframe窗口
                                        let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                        parent.layer.close(index); //再执行关闭
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
