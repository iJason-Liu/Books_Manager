<?php
    /*
     * 添加单本图书
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    //判断登录状态
    if($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    // 查询图书类别
    $type_sql="select * from book_kind";
    $result_type = mysqli_query($db_connect,$type_sql);
    // 查询图书书库
    $stack_sql="select * from book_stack";
    $result_stack = mysqli_query($db_connect,$stack_sql);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>新增图书</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link rel="stylesheet" type="text/css" href="../../skin/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="../../skin/css/modules/layer/layer.css" />
    <style>
        #form_tab{
            width: 72%;
            padding: 20px 50px 40px 20px;
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

    </style>
</head>
	<body style="background: url('../../skin/images/bg3.jpg') top center no-repeat; background-size:cover">
        <form class="layui-form" action="../../controllers/books_source/add_book_check.php" method="post" enctype="multipart/form-data">
        <div id="form_tab">
            <div class="layui-form-item">
                <label class="layui-form-label">ISBN:</label>
                <div class="layui-input-block">
                    <input type="text" name="ISBN" id="ISBN" placeholder="请输入图书的ISBN编号" lay-verify="required" lay-reqtext="请输入图书ISBN！" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">*图书名称:</label>
                <div class="layui-input-block">
                    <input type="text" name="bookname" id="bookname" placeholder="请输入图书名称---手动添加书名号《》" lay-verify="required" lay-reqtext="请输入图书名称！" class="layui-input">
                </div>
                <!-- <div class="layui-form-mid layui-word-aux">*请手动添加书名号《》</div>-->
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作 者:</label>
                <div class="layui-input-block">
                    <input type="text" name="author" id="author" placeholder="请输入图书作者" lay-verify="required" lay-reqtext="请输入作者！" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">出 版 社:</label>
                <div class="layui-input-block">
                    <input type="text" name="publisher" id="publisher" placeholder="请输入图书出版社" lay-verify="required" lay-reqtext="请输入出版社！" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">价 格:</label>
                <div class="layui-input-inline">
                    <input type="number" name="bookprice" id="bookprice" placeholder="单位：元" lay-verify="required" lay-reqtext="请输入图书的单价" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">库 存:</label>
                <div class="layui-input-inline">
                    <input type="number" name="number" id="number" placeholder="单位：本" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图书类别：</label>
                <div class="layui-input-inline">
                  <select name="booktype" id="booktype" lay-verify="required" lay-reqtext="请选择图书类别！">
                        <option value="">请选择类别</option>
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
                    <select name="saveplace" id="saveplace" lay-verify="required" lay-reqtext="请选择书库！">
                        <option value="">请选择书库</option>
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
                <label class="layui-form-label">图书简介:</label>
                <div class="layui-input-block">
                    <textarea name="mark" id="mark" placeholder="请输入图书简介..." lay-verify="required" lay-reqtext="请输入图书简介！" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图书封面:</label>
                <div class="layui-upload-drag" id="bookcover">
                    <div id="tip">
                        <i class="layui-icon"></i>
                        <p>点击上传，或将图片拖拽到此处</p>
                    </div>
                      <div class="layui-hide" id="uploadView">
                        <img src="" alt="图书封面" style="max-width: 196px">
                      </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-top: 45px;">
                    <button type="reset" class="layui-btn layui-btn-primary" value="重置">重 置</button>
                    <button type="submit" class="layui-btn" name="addition" id="addition" lay-submit lay-filter="form_data" value="提交">提 交</button>
                </div>
            </div>
        </form>

        <script src="../../skin/js/layui.simple.js"></script>
<!--        <script src="../../skin/js/jquery-3.3.1.min.js"></script>-->
        <script>
            layui.use(['upload', 'form', 'layer'], function() {
                let form = layui.form
                    ,upload = layui.upload
                    ,layer = layui.layer;
                upload.render({
                    elem: '#bookcover',
                    url: '../../controllers/books_source/upload_bookCover.php', //上传接口
                    accept: 'images', //允许上传的文件类型
                    acceptMime: 'image/jpg, image/png, image/jpeg, image/svg, image/bmp, image/gif',
                    size: 1024 * 3,  //单位kb,允许3mb的文件
                    auto: false, //自动上传
                    exts: 'jpg|png|jpeg|svg|bmp|gif', //文件后缀
                    bindAction: '#addition',
                    before: function (){
                        layer.load(); //上传loading
                    },
                    choose: function(res){
                      //预读本地文件示例，不支持ie8
                      res.preview(function(index, file, result){
                          layui.$('#tip').attr('class', 'layui-hide'); //隐藏上传提示
                          layui.$('#uploadView').removeClass('layui-hide').find('img').attr('src', result); //图片链接（base64）
                      });
                    },
                    done: function(res){
                        layer.closeAll('loading'); //关闭loading
                        if(res.code === 0){
                            layer.msg('上传成功！');
                            layui.$('#tip').attr('class', 'layui-hide'); //隐藏上传提示
                            layui.$('#uploadView').removeClass('layui-hide').find('img').attr('src', res.data);
                        }
                    },
                    error: function (){
                        layer.closeAll('loading'); //关闭loading
                        layer.msg('上传失败！');
                        layui.$('#tip').attr('class', 'layui-hide');
                        return false;
                    }
                })
                //监听提交
                form.on('submit(form_data)', function(data){
                  // console.log(data.field); //打印提交的表单信息
                    // $.ajax({
                    //     url: '../books/add_books_check.php',
                    //     type: 'POST',
                    //     data: data.field,
                    //     dataType: "json",
                    //     success: function (res) {
                    //         console.log(res);
                    //         alert('提交成功！');
                    //     },
                    //     error: function (res) {
                    //         console.log(res);
                    //         alert('提交失败！');
                    //     }
                    // })
                })
            })
        </script>
    </body>
</html>
