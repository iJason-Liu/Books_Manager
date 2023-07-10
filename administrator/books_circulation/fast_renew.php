<?php
    /*
     * 图书续借 快速操作，便捷选择
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $book_id = $_GET['book_id'];
    $user_id = $_SESSION['user_id'];
    //执行sql语句的查询语句
    $sql1 = "select * from book_borrow where card_id='$user_id' and book_id='$book_id'";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>快速续借</title>
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
        /*大于7天*/
        .have{
            color: #009688;
        }
        /*小于7天*/
        .use{
            color: #ff5722 !important;
        }
    </style>
</head>
<body>
    <form class="layui-form" lay-filter="form_data">
        <?php
            while($row = mysqli_fetch_array($result)){
                $left_day = $row['left_day'];
        ?>
        <div id="form_tab">
            <div class="layui-form-item">
                <label class="layui-form-label">借阅卡号:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="card_id" value="<?php echo $row['card_id'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">图书编号:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="book_id" value="<?php echo $row['book_id'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图书名称:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="book_name" value="<?php echo $row['book_name'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">距离到期:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="left_day1" value="<?php echo $left_day.' 天' ?>" class="layui-input color <?php if($left_day<=10)echo 'use';else echo 'have'; ?> ">
                    <input disabled type="text" name="left_day" value="<?php echo $left_day ?>" class="layui-input color layui-hide">
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">续借次数:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="renew_num" value="<?php echo $row['renew_num'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">应还日期:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="back_date" value="<?php echo $row['back_date'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: #ff0000;">*</span>续借期限:</label>
                <div class="layui-input-block" id="rangDate">
                    <input type="radio" name="newDay" value="7" title="7天" checked="">
                    <input type="radio" name="newDay" value="15" title="15天">
                    <input type="radio" name="newDay" value="30" title="30天">
                    <input type="radio" name="newDay" value="60" title="60天">
                    <input type="radio" name="newDay" value="90" title="90天">
                    <input type="radio" name="newDay" value="999" title="买断" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-top: 60px;text-align: right;">
                    <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="续借">续 借</button>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
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
                let left_day = <?php echo $left_day ?>;  //剩余期限
                if(left_day > 7){
                    layer.msg('距离到期时间7天才可以进行续借操作哦~',{
                        icon: 7,
                        shade: .2,
                        time: 2500
                    },function (){
                        let index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    })
                }else{
                    $.ajax({
                        url: '../../controllers/books_circulation/do_fastRenew',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    //关闭当前的iframe窗口
                                    let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                    parent.layer.close(index); //再执行关闭
                                    parent.location.href = './renewBook';
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    shade: .2,
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
