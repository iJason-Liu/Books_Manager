<?php
    /*
     * 添加图书类别
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }

?>
<!DOCTYPE html>
<html>

<head>
    <title>新增图书类别</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link rel="stylesheet" type="text/css" href="../../skin/css/layui.min.css" />
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        #form_tab{
            width: 72%;
            padding: 10px 65px 30px 20px;
            margin: 35px auto;
        }

        #desc{
            width: 100%;
            border: 1px solid #eee;
            padding: 8px;
            display: block;
            min-height: 120px;
            resize: vertical;
        }
    </style>
</head>
	<body>
        <form class="layui-form" lay-filter="form_data">
            <div id="form_tab">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>类别名称:</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" id="name" placeholder="请输入类别名称" lay-reqtext="请输入类别名称！" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">备 注:</label>
                    <div class="layui-input-block">
                        <textarea name="desc" id="desc" placeholder="请输入备注..." class="layui-textarea"></textarea>
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

        <script src="../../skin/js/layui.min.js"></script>
        <script>
            layui.use(['layer', 'form'], function() {
                let $ = layui.jquery
                    ,layer = layui.layer
                    ,form = layui.form;

                $('#submit').on('click',function (){
                    let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    if(data.name === ''){
                        layer.msg('请输入分类名称！', {
                            time: 1200
                        })
                    }else {
                        $.ajax({
                            url: '../../controllers/books_center/addBook_kind_check.php',
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
