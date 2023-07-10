<?php
    /*
     * 更新馆员信息
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $id = $_GET['id'];
    //执行sql语句的查询语句
    $sql1 = "select * from lib_worker where id='$id'";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>更新馆员信息</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="../../skin/css/layui.min.css" />
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        #form_tab{
            width: 82%;
            padding: 0 50px 0 20px;
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
                <label class="layui-form-label">账 号:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="id" id="id" value="<?php echo $row['id'] ?>" class="layui-input color">
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
                <!--<div class="layui-form-mid layui-word-aux">https://www.somd5.com/</div>-->
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

    <script src="../../skin/js/layui.min.js"></script>
    <script type="text/javascript">
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
                        tips: [3,'#666'],
                        time: 2000
                    })
                } else if(!reg.test(data.pwd)){
                    layer.tips('密码必须6至12位，包含字母数字，不能包含空格！', '#pwd',{
                        tips: [3,'#666'],
                        time: 2000
                    })
                } else if(!reg2.test(data.mobile)){
                    layer.tips('手机号码输入不正确！', '#mobile',{
                        tips: [3,'#666'],
                        time: 2000
                    })
                } else{
                    $.ajax({
                        url: '../../controllers/lib_worker/update_worker_check',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            //关闭当前的iframe窗口
                            let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    parent.layui.table.reload('dataList'); //刷新父级窗口的table数据
                                    parent.layer.close(index);
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    //关闭当前的iframe窗口
                                    parent.layer.close(index);
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
