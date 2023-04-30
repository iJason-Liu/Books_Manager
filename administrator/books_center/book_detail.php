<?php
    /*
     * 图书详情查看
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }

    $usertype = $_SESSION['usertype'];
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $id = $_GET['id'];
    //执行sql语句的查询语句
    $sql1 = "select * from book_list where book_id='$id'";
    $result = mysqli_query($db_connect,$sql1);

    // 查询图书类别
    $type_sql="select * from book_type";
    $result_type = mysqli_query($db_connect,$type_sql);
    // 查询图书书库
    $stack_sql="select * from book_stack";
    $result_stack = mysqli_query($db_connect,$stack_sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>图书详细信息</title>
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
            width: 72%;
            padding: 10px 40px 40px 5px;
            margin: 30px auto;
        }

        #mark{
            width: 100%;
            border: 1px solid #eee;
            padding: 8px;
            display: block;
            min-height: 180px;
            resize: vertical;
        }

        .layui-btn{
            width: 120px;
        }

        .color{
            background-color: #f5f5f5;
        }

    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function(){ return false;}
        //禁用浏览器右键点击事件
        document.oncontextmenu = function(){return false;}
        //禁止拖拽
        document.ondragstart=function(){return false}
        //禁止用户选中网页上的内容
        document.onselectstart=function(){return false}
        //禁用复制、剪贴版
        document.onbeforecopy=function(){return false}
        //禁用文本框或者文本域中的文字被选中
        document.onselect=function(){return false;}
    </script>
</head>
	<body style="background: url('../../skin/images/bg3.jpg') top center no-repeat; background-size:cover;">
        <form class="layui-form" action="#" method="post" enctype="multipart/form-data">
            <?php
                while($row = mysqli_fetch_array($result)){
                    $type = $row['book_type'];
                    $stack = $row['save_position'];
                    $desc = $row['mark'];
                    $src = $row['book_cover'];
                    $status = $row['status'];
                    $create_time = $row['create_date'];
                    //更新点击次数
                    $click_num = $row['click_num'];
                    $new_num = $click_num + 1;
                    mysqli_query($db_connect, "update book_list set click_num='$new_num' where book_id='$id'");

                    mysqli_close($db_connect); //关闭数据库资源
            ?>
            <div id="form_tab">
                <fieldset class="layui-elem-field layui-field-title" name="file" id="file">
                    <legend>图书封面</legend>
                    <div class="layui-form-item" style="text-align: center;margin-top: 30px;">
                        <div class="layui-upload-drag" id="bookcover">
                              <div id="uploadView">
                                <img src="<?php echo $src ?>" alt="图书封面" style="max-width: 196px">
                              </div>
                        </div>
                    </div>
                </fieldset>

                <div class="layui-form-item">
                    <label class="layui-form-label">图书编号:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="id" id="id" value="<?php echo $row['book_id'] ?>" class="layui-input color">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">ISBN:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="ISBN" id="ISBN" value="<?php echo $row['ISBN'] ?>" placeholder="ISBN" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>图书名称:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="bookname" id="bookname" value="<?php echo $row['book_name'] ?>" placeholder="图书名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">作 者:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="author" id="author" placeholder="作者" value="<?php echo $row['author'] ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">出 版 社:</label>
                    <div class="layui-input-block">
                        <input disabled type="text" name="publisher" id="publisher" value="<?php echo $row['publisher'] ?>" placeholder="出版社" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">价 格:</label>
                    <div class="layui-input-inline">
                        <input disabled type="number" name="bookprice" id="bookprice" value="<?php echo $row['price'] ?>" placeholder="单位：元" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位：元</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">库 存:</label>
                    <div class="layui-input-inline">
                        <input disabled type="number" name="number" id="number" value="<?php echo $row['number'] ?>" placeholder="单位：本" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位：本</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">图书类别：</label>
                    <div class="layui-input-inline">
                      <select disabled name="booktype" id="booktype">
                            <option value="<?php echo $type ?>"><?php echo $type ?></option>
                          <?php
                                while($row=mysqli_fetch_array($result_type)){
                            ?>
                            <option value="<?php echo $row['type_name']?>"><?php echo $row['type_name']?></option>
                            <?php
                                }
                            ?>
                      </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">保存书库：</label>
                    <div class="layui-input-inline">
                        <select disabled name="saveplace" id="saveplace">
                            <option value="<?php echo $stack ?>"><?php echo $stack ?></option>
                            <?php
                                while($row=mysqli_fetch_array($result_stack)){
                            ?>
                            <option value="<?php echo $row['stack_name'].'_'.$row['stack_position']?>"><?php echo $row['stack_name'].'_'.$row['stack_position']?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color: #ff0000;">*</span>图书状态:</label>
                    <div class="layui-input-inline">
                        <?php
                            if($status == 0) {
                                echo "<input disabled type='text' name='status' id='status' style='color: #429488' value='在库' class='layui-input'>";
                            }else{
                                echo "<input disabled type='text' name='status' id='status' style='color: #ff5722' value='已借出' class='layui-input'>";
                            }
                        ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">入库时间:</label>
                    <div class="layui-input-inline">
                        <input disabled type="text" name="create_time" id="create_time" value="<?php echo $create_time ?>" placeholder="1999-10-11 00:00:00" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">图书简介:</label>
                    <div class="layui-input-block">
                        <textarea disabled name="mark" id="mark" placeholder="图书简介" class="layui-textarea"><?php echo $desc ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-top: 45px;">
                        <button type="button" class="layui-btn layui-btn-primary" id="back"  value="返回">返 回</button>
                        <button type="button" class="layui-btn" name="go" id="go" value="借阅">借 阅</button>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </form>

        <script src="../../skin/js/layui.min.js"></script>
        <script src="../../skin/js/jquery-3.3.1.min.js"></script>
        <script>
            let usertype = '<?php echo $usertype ?>'; //用户身份
            layui.use(['layer'], function() {
                let layer = layui.layer;
                // 返回操作，关闭窗口
                $('#back').click(function (){
                    //关闭当前的iframe窗口
                    let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭
                })
                $('#go').click(function (){
                    layer.load(3,{
                        content: 'loading',
                        shade: 0.2,
                        time: 1000
                    });
                    setTimeout("parent.location.href = '../books_circulation/borrowBook'",1000)
                })
            })
        </script>
    </body>
</html>
