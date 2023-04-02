<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../login/login.php'</script>";
    }

?>
<!DOCTYPE html>
<html>

<head>
    <title>新增读者</title>
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
            padding: 10px 50px 40px 20px;
            margin: 35px auto;
        }

        .layui-btn{
            width: 120px;
        }

        .img{
            width: 26px;
            height: 19px;
            position: relative;
            top: -30px;
            left: 90.5%;
            cursor: pointer;
        }

    </style>
</head>
	<body>
        <form class="layui-form" lay-filter="form_data">
            <div id="form_tab">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>姓 名:</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" id="name" placeholder="请输入姓名" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性 别:</label>
                    <div class="layui-input-block">
                        <input type='radio' name='sex' value='男' title='男' checked>
                        <input type='radio' name='sex' value='女' title='女'>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">学院:</label>
                    <div class="layui-input-block">
                        <input type="text" name="department" id="department" placeholder="请输入学院" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">所属班级:</label>
                    <div class="layui-input-block">
                        <input type="text" name="class" id="class" placeholder="请输入班级" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">身 份:</label>
                    <div class="layui-input-inline">
                        <select name="user_type">
                            <option value="学生">学生</option>
                            <option value="教师">教师</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密 码:</label>
                    <div class="layui-input-block">
                        <input type="password" name="pwd" id="pwd" placeholder="请输入密码" class="layui-input">
                        <img title="隐藏" class="img" src="../images/showPwd.png">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">联系电话:</label>
                    <div class="layui-input-block">
                        <input type="tel" name="mobile" id="mobile" placeholder="请输入联系电话" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 50px;">
                        <button type="reset" class="layui-btn layui-btn-primary" value="重置">重 置</button>
                        <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="提交">提 交</button>
                    </div>
                </div>
            </div>
        </form>

        <script src="../js/layui.simple.js"></script>
        <script>
            layui.use(['layer', 'form'], function() {
                var $ = layui.jquery
                    ,layer = layui.layer
                    ,form = layui.form;

                $('#submit').on('click',function (){
                    var data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    var reg = /^(?=.*[A-Za-z])(?=.*\d)[\S]{6,12}$/; //密码正则
                    var reg2 = /^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/; //电话号码正则
                    if(data.name === ''){
                        layer.tips('姓名不能为空！', '#name',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    }else if(!reg.test(data.pwd)){
                        layer.tips('密码必须6至12位，包含字母数字，不能包含空格！', '#pwd',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                    }else if(data.department === ''){
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
                            url: '../reader/add_reader_check.php',
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
                                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                        parent.layer.close(index); //再执行关闭
                                    })
                                } else {
                                    layer.msg(res.msg, {
                                        icon: 7,
                                        time: 1500
                                    }, function () {
                                        //关闭当前的iframe窗口
                                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                        parent.layer.close(index); //再执行关闭
                                    })
                                }
                            }
                        })
                    }
                })

                //显示隐藏密码
                $('.img').on('click', function (){
                    var flag = $('#pwd').attr('type');
                    if(flag === 'password'){
                        $('#pwd').attr('type', 'text');
                        $('.img').attr('title', '显示').attr('src', '../images/hidePwd.png');
                    }else{
                        $('#pwd').attr('type', 'password');
                        $('.img').attr('title', '隐藏').attr('src', '../images/showPwd.png');
                    }
                })
            })
        </script>
    </body>
</html>
