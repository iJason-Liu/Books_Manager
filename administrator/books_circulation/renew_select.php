<?php
    /*
     * 图书续借操作选择页面
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $book_id = $_GET['book_id'];
    $user_id = $_SESSION['user_id'];
    //执行sql语句的查询语句
    $sql1 = "select * from book_borrow where card_id='$user_id' and book_id=$book_id";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>图书续借</title>
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
                    <label class="layui-form-label">应还日期:</label>
                    <div class="layui-input-block">
                        <input type="text" disabled name="back_date" value="<?php echo $row['back_date'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">距离到期:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="left_day1" value="<?php echo $left_day.' 天' ?>" class="layui-input color <?php if($left_day<=10)echo 'use';else echo 'have'; ?> ">
                        <input disabled type="text" name="left_day" value="<?php echo $left_day ?>" class="layui-input color layui-hide">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>续借期限:</label>
                    <div class="layui-input-block" id="rangDate">
                        <div class="layui-input-inline" style="width: 130px;">
                            <input disabled type="text" autocomplete="off" name="startDate" id="startDate" class="layui-input color" placeholder="开始日期">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 130px;">
                            <input type="text" autocomplete="off" name="endDate" id="endDate" class="layui-input" placeholder="结束日期">
                        </div>
                    </div>
                    <div style="margin: 15px 0 0 115px;color: #ff0000;">共计：<span class="selDay1">0</span> 天</div>
                    <input type="text" class="selDay layui-hide" name="renewDay" value="0">
                </div>
                <div class="layui-form-item layui-hide">
                    <label class="layui-form-label">续借次数:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="renew_num" value="<?php echo $row['renew_num'] ?>" class="layui-input color">
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
            layui.use(['layer', 'form', 'laydate'], function() {
                let $ = layui.jquery
                    ,layer = layui.layer
                    ,laydate = layui.laydate
                    ,form = layui.form;

                //获取当前日期
                let nowDate = new Date();
                let year = nowDate.getFullYear(); //获取当前年
                let month = nowDate.getMonth() + 1; //获取当前月
                let day = nowDate.getDate(); //
                if(month < 10){
                    month = '0'+month;
                }
                if(day < 10){
                    day = '0'+day;
                }
                let today = year+'-'+month+'-'+day;
                // console.log(today);
                let parseDay = Date.parse(today); //赋予当前日期值给第一个日期框

                //选择日期
                laydate.render({
                    elem: '#startDate',
                    value: today, //赋予初始值，当前日期
                })
                laydate.render({
                    elem: '#endDate',
                    btns: ['now', 'confirm'],
                    min: today,
                    done: function (value){
                        // console.log(value); //选择的日期
                        let startDate = new Date(today);
                        let endDate = new Date(value);
                        let selDay = Math.abs(parseInt((endDate - startDate)/1000/3600/24));
                        $('.selDay1').text(selDay);  //计算出选择了多少天
                        $('.selDay').val(selDay);  //计算出选择了多少天，赋值input传到后台
                    }
                })

                $('#submit').on('click',function (){
                    let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    let back_date = data.back_date;  //应还日期
                    let left_day = <?php echo $left_day ?>;  //剩余期限
                    let selDays = $('.selDay').val();  //选择的续借天数，最大支持90天
                    if(left_day > 7){
                        layer.msg('距离到期时间7天才可以进行续借操作哦~',{
                            icon: 7,
                            shade: .2,
                            time: 2500
                        },function (){
                            let index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        })
                    }else if(data.endDate === ''){
                        layer.msg('请选择结束日期！',{
                            time: 2000
                        })
                    }else if(selDays > 90){
                        layer.msg('当前仅支持最长续借期限为90天！',{
                            time: 2000
                        })
                    }else{
                        $.ajax({
                            url: '../../controllers/books_circulation/do_renew.php',
                            type: 'POST',
                            data: JSON.stringify(data),
                            dataType: 'json',
                            success: function (res) {
                                // console.log(res);
                                if (res.code === 200) {
                                    layer.msg(res.msg, {
                                        icon: 1,
                                        shade: .2,
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
