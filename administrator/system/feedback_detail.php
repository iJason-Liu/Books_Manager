<?php
    /*
     * 反馈详情页面
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $id = $_GET['id'];  //反馈id
    // $user_id = $_SESSION['user_id'];
    //执行sql语句的查询语句
    $sql1 = "select * from feedback where id='$id'";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>反馈详情</title>
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
            width: 87%;
            padding: 10px 30px 0 0;
            margin: 25px auto;
        }

        .layui-btn{
            width: 120px;
        }

        .color{
            background-color: #f5f5f5;
        }

        #content{
            width: 100%;
            border: 1px solid #eee;
            padding: 8px;
            display: block;
            height: 210px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <form class="layui-form" lay-filter="form_data">
        <?php
            while($row = mysqli_fetch_array($result)){
                $user_id =$row['user_id'];
                $user_name =$row['user_name'];
        ?>
        <div id="form_tab">
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">id:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="id" value="<?php echo $row['id'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户ID:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="user_id" value="<?php echo $user_id=='' || $user_id==null ? '匿名' : $user_id ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户名:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="user_name" value="<?php echo $user_name=='' || $user_name==null ? '匿名' : $user_name ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">提交时间:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="sub_time" value="<?php echo $row['sub_time'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: #ff0000;">*</span>反馈内容:</label>
                <div class="layui-input-block">
                    <textarea disabled name="content" id="content" class="layui-textarea"><?php echo $row['content'] ?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-top: 60px;text-align: center;">
                    <button type="button" class="layui-btn layui-btn-primary" name="back" id="back" lay-submit value="返回">返 回</button>
                    <button type="button" class="layui-btn layui-btn-danger" name="submit" id="submit" lay-submit value="删除">删 除</button>
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
                let data = form.val('form_data');
                layer.confirm('确认删除这条反馈记录吗？',{title: '温馨提示'}, function (index) {
                    $.ajax({
                        url: '../../controllers/system/del_feedback',
                        type: 'POST',
                        data: {
                            id: data.id,
                        },
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            let frmindex = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    parent.layui.table.reload('dataList'); //刷新父级窗口的table数据
                                    //关闭当前的iframe窗口
                                    parent.layer.close(frmindex);
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    //关闭当前的iframe窗口
                                    parent.layer.close(frmindex);
                                })
                            }
                        }
                    })
                    layer.close(index);
                }, function () {
                    parent.layer.close(parent.layer.getFrameIndex(window.name));
                })
            })

            $('#back').on('click',function (){
                parent.layer.close(parent.layer.getFrameIndex(window.name));
            })
        })
    </script>
</body>

</html>
