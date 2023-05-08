<?php
    /*
     * 提交用户意见或建议
     */
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>用户反馈</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="../skin/css/layui.min.css" />
    <link rel="stylesheet" type="text/css" href="../skin/css/modules/layer/layer.css" />
    <style>
        #form_tab{
            width: 94%;
            /*padding: 0 55px 0 0;*/
            margin: 10px auto;
        }

        #desc{
            width: 100%;
            border: 1px solid #eee;
            border-radius: 3px;
            padding: 8px;
            min-height: 260px;
            resize: vertical;
        }

        .layui-btn{
            width: 120px;
        }
    </style>
</head>
<body>
    <form class="layui-form" lay-filter="form_data">
        <div id="form_tab">
            <div class="layui-form-item">
                <!--<label class="layui-form-label">意见建议:</label>-->
                <!--<div class="layui-input-block">-->
                    <textarea name="desc" id="desc" placeholder="请输入您的宝贵意见或建议..." class="layui-textarea"></textarea>
                <!--</div>-->
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-top: 10px;text-align: right;">
                    <button type="reset" class="layui-btn layui-btn-primary" value="清空">清 空</button>
                    <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="提交">提 交</button>
                </div>
            </div>
        </div>
    </form>

    <script src="../skin/js/layui.min.js"></script>
    <script>
        layui.use(['layer', 'form'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,form = layui.form;

            $('#submit').on('click',function (){
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                // console.log(data);
                if(data.desc === ''){
                    layer.msg('请输入内容后再提交！', {
                        time: 1500
                    })
                }else {
                    $.ajax({
                        url: '../../controllers/views/submit_feedback',
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
                                    time: 2000
                                }, function () {
                                    parent.layer.close(index); //再执行关闭
                                })
                            }else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    shade: .2,
                                    time: 1500
                                }, function () {
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
