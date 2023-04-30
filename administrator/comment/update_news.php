<?php
    /*
     * 编辑文章
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
    $sql1 = "select * from news_notice where id='$id'";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>编辑文章详情</title>
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
    <link rel="stylesheet" href="https://unpkg.com/@wangeditor/editor@latest/dist/css/style.css">
    <style>
        #form_tab{
            width: 82%;
            padding: 0 50px 0 20px;
            margin: 35px auto;
        }

        .layui-btn{
            width: 150px;
        }

        .color{
            background-color: #f5f5f5;
        }

        #tip{
            margin-top: 25%;
        }

        /*富文本编辑器*/
        #editor—wrapper {
            border: 1px solid #ccc;
            z-index: 100; /* 按需定义 */
            border-radius: 3px;
        }
        #toolbar-container {
            border-bottom: 1px solid #ccc;
        }
        #editor-container {
            min-height: 520px;
        }
        .w-e-text-container [data-slate-editor]{
            min-height: 520px;
        }
    </style>
</head>
<body>
    <form class="layui-form" lay-filter="form_data">
        <?php
            while($row = mysqli_fetch_array($result)){
                $type = $row['type'];
                $content = $row['content'];
        ?>
        <div id="form_tab">
            <div class="layui-form-item">
                <label class="layui-form-label">封 面:</label>
                <div class="layui-upload-drag" id="cover_img">
                    <div class="layui-hide" id="tip">
                        <i class="layui-icon"></i>
                        <p>点击上传，或将图片拖拽到此处，最大允许上传2MB的图片</p>
                    </div>
                    <div id="uploadView">
                        <img src="<?php echo $row['cover_img'] ?>" alt="文章封面" style="width: 520px;height: 360px;">
                    </div>
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">序 号:</label>
                <div class="layui-input-block">
                    <input type="text" name="id" id="id" value="<?php echo $row['id'] ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: #ff0000;">*</span>文章标题:</label>
                <div class="layui-input-block">
                    <input type="text" name="title" value="<?php echo $row['title'] ?>" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: #ff0000;">*</span>作 者:</label>
                <div class="layui-input-block">
                    <input type="text" name="author" value="<?php echo $row['author'] ?>" placeholder="请输入作者" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">类 型:</label>
                <div class="layui-input-block color">
                    <select disabled name="type">
                        <option value="<?php echo $type ?>"><?php echo $type == 1 ? '新闻资讯' : '通知公告' ?></option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">发布时间:</label>
                <div class="layui-input-block">
                    <input disabled type="text" name="sub_time" value="<?php echo $row['sub_time'] ?>" class="layui-input color">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: #ff0000;">*</span>内 容:</label>
                <div class="layui-input-block" id="editor—wrapper">
                    <div id="toolbar-container"></div>
                    <div id="editor-container"></div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-top: 50px;text-align: center;">
                    <button type="button" class="layui-btn layui-btn-danger" name="delete" id="delete" value="删除">删 除</button>
                    <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="更新">更 新</button>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </form>

    <script src="../../skin/js/layui.min.js"></script>
    <script src="https://unpkg.com/@wangeditor/editor@latest/dist/index.js"></script>
    <script type="text/javascript">
        layui.use(['layer', 'form', 'upload'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,upload = layui.upload
                ,form = layui.form;

            let html = '';  //获取富文本框的内容
            let cover = '';  //封面图片

            upload.render({
                elem: '#cover_img',
                url: '../../controllers/comment/upload_cover', //上传接口
                accept: 'images', //允许上传的文件类型
                acceptMime: 'image/jpg, image/png, image/jpeg, image/gif',
                size: 1024 * 2,  //单位kb,允许2mb的文件
                auto: true, //自动上传
                exts: 'jpg|png|jpeg|gif', //文件后缀
                field: 'article_cover',
                // bindAction: '#submit',
                before: function (){
                    layer.load(3,{
                        shade: .2,
                        scrollbar: false,
                        content: 'loading'
                    }); //上传loading
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
                        layui.$('#uploadView').removeClass('layui-hide').find('img').attr('src', res.data.url);
                        cover = res.data.href;
                    }
                },
                error: function (){
                    layer.closeAll('loading'); //关闭loading
                    layer.msg('上传失败！');
                    layui.$('#tip').attr('class', 'layui-hide');
                    return false;
                }
            })

            //建立富文本编辑器(wangEditor)
            const { createEditor, createToolbar } = window.wangEditor;
            // 编辑器配置
            const editorConfig = {
                placeholder: '请输入内容...',
                autoFocus: false,   //自动聚焦
                scroll: false,  //编辑器高度自增
                MENU_CONF: {
                    //修改图片上传配置
                    uploadImage: {
                        server: '../../controllers/comment/upload_img',
                        fieldName: 'article_img',
                        maxFileSize: 3 * 1024 * 1024,  //3M大小
                        maxNumberOfFiles: 3,   //可上传数量
                        timeout: 10 * 1000, // 超时10秒
                        headers: {
                            Accept: 'multipart/form-data'
                        },
                        onBeforeUpload(file) {  //上传前回调
                            // console.log('上传前')
                        },
                        onSuccess(file, res){  //上传成功回调
                            console.log(file.name+'上传成功', res);
                        },
                        onFailed(file, res){  //上传失败回调
                            console.log(file.name+'上传失败', res);
                        },
                        onError(file){  //上传错误或超时回调
                            layer.msg('上传超时');
                        }
                    }
                },
                onChange(editor) {  // 内容改变事件
                    html = editor.getHtml();  //获取编辑器内的值
                    // console.log('editor content', html);
                },
                onBlur(editor){  // 失去焦点触发事件
                    console.log('失去焦点');
                }
            }
            const editor = createEditor({
                selector: '#editor-container',
                html: '<p><br></p>',
                config: editorConfig,
                mode: 'default', // or 'simple'
            })
            editor.setHtml('<?php echo $content; ?>');  //把原内容赋值在编辑器里
            // 工具栏配置
            const toolbarConfig = {
                // 排除不要的工具
                excludeKeys: [
                    'todo',  //todo清单
                    'group-video',  //上传视频
                    'fullScreen',    //全屏
                ],
                // modalAppendToBody: true
            };
            const toolbar = createToolbar({
                editor,
                selector: '#toolbar-container',
                config: toolbarConfig,
                mode: 'default', // or 'simple'
            });
            // console.log(editor.getMenuConfig('uploadImage'));  //获取上传图片的配置
            // console.log(toolbar.getConfig().toolbarKeys);  //输出所有菜单组

            $('#submit').on('click',function (){
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                // console.log(data);
                // console.log(html);  //富文本框的内容
                // console.log(cover);  //封面链接
                if(data.title === ''){
                    layer.tips('文章标题不能为空！', '#title',{
                        tips: [1,'#666'],
                        time: 2000
                    })
                    $('#title').focus();
                }else if(data.author === ''){
                    layer.tips('请输入文章作者！', '#author',{
                        tips: [1,'#666'],
                        time: 2000
                    })
                    $('#author').focus();
                }else if(html === '' || html === null){
                    layer.msg('请编辑文章内容后再提交！', {
                        icon: 7,
                        shade: .2,
                        time: 2000
                    })
                    // editor.focus();
                }else {
                    $.ajax({
                        url: '../../controllers/comment/update_news_check',
                        type: 'POST',
                        data: {
                            form_data: JSON.stringify(data),
                            content: html,
                            cover: cover,
                            flag: 1,   //提交类型  1更新  2删除
                        },
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            //得到当前iframe层的索引
                            let index = parent.layer.getFrameIndex(window.name);
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 2000
                                }, function () {
                                    //刷新父级窗口的table数据
                                    parent.layui.table.reload('dataList');
                                    //执行关闭
                                    parent.layer.close(index);
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    //执行关闭
                                    parent.layer.close(index);
                                })
                            }
                        }
                    })
                }
            })

            $('#delete').on('click',function () {
                let data = form.val('form_data'); //获取表格中的所有数据 携带name属性
                layer.confirm('确定删除《'+data.title+'》这篇文章吗？',{title: '温馨提示'}, function (index) {
                    $.ajax({
                        url: '../../controllers/comment/update_news_check',
                        type: 'POST',
                        data: {
                            form_data: JSON.stringify(data),
                            flag: 2,   //提交类型  1更新  2删除
                        },
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            //得到当前iframe层的索引
                            let index = parent.layer.getFrameIndex(window.name);
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 2000
                                }, function () {
                                    //刷新父级窗口的table数据
                                    parent.layui.table.reload('dataList');
                                    //执行关闭
                                    parent.layer.close(index);
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 7,
                                    shade: .2,
                                    time: 1500
                                }, function () {
                                    //执行关闭
                                    parent.layer.close(index);
                                })
                            }
                        }
                    })
                    layer.close(index);
                })
            })
        })
    </script>
</body>

</html>
