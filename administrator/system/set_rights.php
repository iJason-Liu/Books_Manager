<?php
    /*
     * 设置用户权限
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $id = $_GET['id'];
    //执行sql语句的查询语句
    $sql1 = "select * from rights where id='$id'";
    $result = mysqli_query($db_connect,$sql1);
    $row = mysqli_fetch_array($result);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>权限配置</title>
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
            width: 85%;
            padding: 0 50px 0 0;
            margin: 35px auto;
        }

        .layui-btn{
            width: 130px;
        }

        .color{
            background-color: #f5f5f5;
        }

        .layui-form-item .layui-form-checkbox[lay-skin=primary] {
            margin-top: 20px;
            width: 135px;
        }

        .box_title{
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form class="layui-form" lay-filter="form_data">
        <div id="form_tab">
            <div class="layui-form-item">
                <label class="layui-form-label">账 号:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="id" id="id" value="<?php echo $row['id'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户名:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="user_name" id="user_name" value="<?php echo $row['user_name'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label box_title"><span style="color: #ff0000;">*</span>权限列表:</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="lib_worker" lay-skin="primary" title="馆员档案" value="1" <?php if($row['lib_worker']==1) echo 'checked' ?>>
                    <input type="checkbox" name="reader_list" lay-skin="primary" title="读者档案" value="1" <?php if($row['reader_list']==1) echo 'checked' ?>>
                    <input type="checkbox" name="reader_kind" lay-skin="primary" title="读者类型" value="1" <?php if($row['reader_kind']==1) echo 'checked' ?>>
                    <input type="checkbox" name="book_kind" lay-skin="primary" title="图书类别" value="1" <?php if($row['book_kind']==1) echo 'checked' ?>>
                    <input type="checkbox" name="book_manager" lay-skin="primary" title="图书管理" value="1" <?php if($row['book_manager']==1) echo 'checked' ?>>
                    <input type="checkbox" name="borrowBook" lay-skin="primary" title="图书借阅" value="1" <?php if($row['borrowBook']==1) echo 'checked' ?>>
                    <input type="checkbox" name="record_search" lay-skin="primary" title="借阅记录查询" value="1" <?php if($row['record_search']==1) echo 'checked' ?>>
                    <input type="checkbox" name="comment_center" lay-skin="primary" title="评论审批管理" value="1" <?php if($row['comment_center']==1) echo 'checked' ?>>
                    <input type="checkbox" name="news_notice" lay-skin="primary" title="新闻公告发布" value="1" <?php if($row['news_notice']==1) echo 'checked' ?>>
                    <input type="checkbox" name="feedBack" lay-skin="primary" title="意见反馈查看" value="1" <?php if($row['feedBack']==1) echo 'checked' ?>>
                    <input type="checkbox" name="rights_center" lay-skin="primary" title="权限管理" value="1" <?php if($row['rights_center']==1) echo 'checked' ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-top: 65px;text-align: center;">
                    <button type="reset" class="layui-btn layui-btn-primary" id="cancel" value="取消">取 消</button>
                    <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="确认">确 认</button>
                </div>
            </div>
        </div>
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
                let index = layer.load(3,{
                    shade: .2,
                    content: 'loading'
                });
                $.ajax({
                    url: '../../controllers/system/set_rights_check',
                    type: 'POST',
                    data: JSON.stringify(data),
                    dataType: 'json',
                    success: function (res) {
                        // console.log(res);
                        layer.close(index);
                        //关闭当前的iframe窗口
                        let frmindex = parent.layer.getFrameIndex(window.name);
                        if (res.code === 200) {
                            layer.msg(res.msg, {
                                icon: 6,
                                shade: .2,
                                time: 2000
                            }, function () {
                                parent.location.reload();  //刷新父级窗口
                                parent.layer.close(frmindex); //再执行关闭
                            })
                        } else {
                            layer.msg(res.msg, {
                                icon: 7,
                                shade: .2,
                                time: 2000
                            }, function () {
                                //关闭当前的iframe窗口
                                parent.layer.close(frmindex);
                            })
                        }
                    }
                })
            })

            $('#cancel').on('click',function () {
                parent.layer.close(parent.layer.getFrameIndex(window.name));
            })
        })
    </script>
</body>

</html>
