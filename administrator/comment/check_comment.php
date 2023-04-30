<?php
    /*
     * 评论审核页面
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $comment_id = $_GET['comment_id'];  //评论id
    $user_id = $_SESSION['user_id'];
    //执行sql语句的查询语句
    $sql1 = "select * from book_comment where comment_id='$comment_id'";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>评论审核</title>
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

        #audit{
            width: 90%;
            height: 86%;
            display: none;
            margin: 12px auto;
            padding: 0 30px 0 0;
        }

        .audit{
            width: 100%;
            height: 160px;
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 3px;
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
                    <label class="layui-form-label">用户名:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="user_name" value="<?php echo $row['user_name'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">评论图书:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="book_name" value="<?php echo $row['book_name'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">评论时间:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="createtime" value="<?php echo $row['createtime'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>评论内容:</label>
                    <div class="layui-input-block">
                        <textarea disabled name="content" id="content" class="layui-textarea"><?php echo $row['content'] ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 60px;text-align: right;">
                        <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="审核">审 核</button>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </form>

        <!--审核意见弹窗-->
        <div id="audit">
            <form class="layui-form" lay-filter="audit_form">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>状 态:</label>
                    <div class="layui-input-block">
                        <input type='radio' name='status' value='1' title='审核通过' checked>
                        <input type='radio' name='status' value='2' title='审核驳回'>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">审核意见:</label>
                    <div class="layui-input-block">
                        <textarea name="audit" class="layui-textarea audit" placeholder="请输入审核意见..."></textarea>
                    </div>
                </div>
            </form>

        </div>

        <script src="../../skin/js/layui.min.js"></script>
        <script type="text/javascript">
            layui.use(['layer', 'form', 'laydate'], function() {
                let $ = layui.jquery
                    ,layer = layui.layer
                    ,form = layui.form;

                $('#submit').on('click',function (){
                    // let data = form.val('audit_form'); //获取审核表格中的所有数据 携带name属性
                    // console.log(data);
                    let index = layer.open({
                        type: 1,
                        title: '<i class="layui-icon layui-icon-edit"></i> 填写审核意见',
                        area: ['460px', '65%'],
                        // skin: 'layui-layer-molv',
                        btn: ['确定', '取消'],
                        move: true,
                        content: $('#audit'),
                        yes: function (){  //确定按钮
                            let comment_id = <?php echo $comment_id ?>;
                            let status = $("input[name='status']:checked").val();  //选择的状态
                            let audit = $(".audit").val();  //审核意见
                            $.ajax({
                                url: '../../controllers/comment/do_check',
                                type: 'POST',
                                data: {
                                    comment_id: comment_id,
                                    status: status,
                                    audit: audit
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
                        },
                        cancel: function (){  //右上角关闭按钮  执行cancel和end
                            // console.log('关闭');
                        },
                        end: function (){  //取消回调
                            // console.log('取消');
                        }
                    })
                })
            })
        </script>
    </body>
</html>
