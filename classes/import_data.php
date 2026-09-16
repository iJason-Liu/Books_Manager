<?php
    /*
     * 上传Excel文件
     */
    session_save_path('../session/');
    session_start();
    include "../classes/check_rights.php";
    if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../oauth/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $import_type = $_GET['import_type']; //获取模板类型

?>
<!DOCTYPE html>
<html>

<head>
    <title>批量导入数据</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--<meta name="referrer" content="never"/>-->
    <link rel="stylesheet" type="text/css" href="../skin/css/layui.min.css" />
    <link rel="stylesheet" type="text/css" href="../skin/css/modules/layer/layer.css" />
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
    <style>
        .layui-upload{
            width: 80%;
            padding: 25px;
            margin: 30px auto;
        }

        .box{
            border: 1px dashed #429488;
            height: 280px;
            padding: 20px;
            background: #fafafa;
        }

        .layui-btn+.layui-btn{
            margin-left: 0;
        }

        .btn{
            margin-top: 20px;
            width: 100%;
        }
    </style>
</head>
<body >
    <div class="layui-upload">
        <fieldset class="layui-elem-field layui-field-title box">
            <legend>选择文件</legend>
            <div class="layui-upload-list" style="max-width: 100%;margin-top: 10px;">
                <table class="layui-table">
                    <colgroup>
                        <col width="260">
                        <col width="130">
                        <col width="260">
                        <col width="130">
                    </colgroup>
                    <thead align="center">
                        <tr>
                            <th>文件名称</th>
                            <th>大小</th>
                            <th>上传进度</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="fileList"></tbody>
                </table>
            </div>
        </fieldset>
        <span style="color: #ff0000;position: absolute;margin:-50px 0 0 20px;">注意：请先下载模板整理数据后再上传，切勿修改格式！</span>
        <div class="btn">
            <div style="float: left">
<!--                <a href="/template/图书信息表（模板）.xlsx" download="图书信息表（模板）.xlsx">-->
<!--                    <button type="button" class="layui-btn layui-btn-normal" id="download">下载模板</button>-->
<!--                </a>-->
                <a href="../classes/download?import_type=<?php echo $import_type ?>" target="_blank">
                    <button type="button" class="layui-btn layui-btn-normal" id="download">下载模板</button>
                </a>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="layui-btn layui-btn-normal" id="import">选择文件</button>
            </div>
            <div style="float: right">
                <button type="button" class="layui-btn" id="actionUpload"><i class="layui-icon"></i>开始上传</button>
                <input type="hidden" id="actionUpload2">
            </div>
        </div>
    </div>
    <script src="../skin/js/layui.min.js"></script>
    <script src="../skin/js/jquery-3.3.1.min.js"></script>
    <script>
        let files = {};
        let import_type = <?php echo $import_type ?>;
         // console.log(import_type);
        layui.use(['upload','element', 'layer'], function() {
            let $ = layui.jquery
                ,upload = layui.upload
                ,layer = layui.layer
                ,element = layui.element;

            let uploadListIns = upload.render({
                elem : '#import',
                elemList: $('#fileList'), //列表元素对象
                url : '../classes/import_Excel',
                data: {
                  import_type: import_type  //上传的文件类型
                },
                size: 1024 * 8,  //限制文件大小，单位 KB
                accept: 'file', //上传文件
                acceptMime: '.xlsx, .xls, .csv',  //文件类型 .pdf
                exts: 'xls|xlsx|csv', //允许上传的文件后缀
                auto: false, //自动上传
                bindAction: '#actionUpload',
                before: function (){
                    layer.load(3,{
                        shade: 0.2,
                        content: 'loading'
                    }) //加载loading
                },
                choose: function(obj){
                    // console.log(obj);
                    files = obj.pushFile(); //将选择的文件追加到文件队列
                    //console.log(files);
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                        ,'<td><div class="layui-progress" lay-filter="progress-'+ index +'"><div class="layui-progress-bar" lay-percent=""></div></div></td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-xs layui-btn-danger delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));

                        //删除文件
                        tr.find('.delete').on('click', function(){
                            delete files[index]; //删除对应的文件
                            tr.remove();
                            // 移除禁用样式
                            $('#import').removeAttr('disabled').removeClass('layui-btn-disabled').addClass('layui-btn-normal');
                            uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                        });
                        // 追加完成添加禁用样式
                        $('#import').removeClass('layui-btn-normal').addClass('layui-btn-disabled').attr('disabled','disabled');

                        $('#fileList').append(tr);
                        element.render('progress'); //渲染新加的进度条组件
                    })
                },
                done : function(res,index) {
                    var that = this;
                    if(res.code === 200){
                        //上传成功
                        layer.msg(res.msg,{
                            shade: 0.2,
                            icon: 1,
                            time: 3000
                        },function (){
                            //关闭当前的iframe窗口
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            //2s后执行关闭
                            parent.layer.close(index);
                            if(import_type === 0){
                                parent.layui.table.reload("bookcase");
                            }else{
                                parent.layui.table.reload("dataList");
                            }
                        })
                    }else{
                        layer.msg(res.msg,{
                            shade: 0.2,
                            icon: 7,
                            time: 3000
                        },function (){
                            var tr = that.elemList.find('tr#upload-'+ index)
                                ,tds = tr.children();
                            tds.eq(3).html(''); //清空操作
                            tr.remove();
                            delete files[index]; //删除文件队列已经上传成功的文件
                            $('#import').removeAttr('disabled').removeClass('layui-btn-disabled').addClass('layui-btn-normal');
                        })
                    }
                    layer.closeAll('loading'); //关闭loading
                },
                error: function (res){
                    layer.closeAll('loading'); //关闭loading
                    // console.log(res);
                },
                //进度条
                progress: function(n, elem, e, index){
                  element.progress('progress-'+ index, n + '%'); //执行进度条。n 即为返回的进度百分比
                }
            })
        })

        //判断点击上传时是否了选择文件
        $('#actionUpload').on('click', e=> {
            if (Object.keys(files).length > 0) {
                $('#actionUpload2').click();
            } else {
                layer.msg('请选择文件后再上传!',{
                    icon: 7,
                    shade: .2,
                    time: 1500
                })
            }
        })

        //#download
        // $('#a').on('click',function (){
        //     var import_type = 1;  //上传的文件类型

            //第一种方式：创建a标签🏷下载
            // var a = document.createElement('a');
            // var url = '../template/';
            // var fileName = '图书信息表（模板）.xlsx';
            //
            // a.style.display = 'none';
            // a.setAttribute('target', '_blank');
            // fileName && a.setAttribute('download', fileName);
            // a.href = url;
            // document.body.appendChild(a);
            // a.click();
            // document.body.removeChild(a);

            //第二种方式：xhr方式下载
            // var baseurl = '../template/';
            // var xhr = new XMLHttpRequest();
            // xhr.responseType = 'blob';
            // xhr.open('GET', baseurl, true);
            // // 设置请求头
            // xhr.setRequestHeader('Content-Type', 'application/octet-stream');
            // // response.setHeader('Access-Control-Allow-Headers', '*');
            // xhr.onload = function(){
            //     var blob = xhr.response;
            //     // console.log(blob);
            //     if(blob.status === 200){
            //         var reader = new FileReader();
            //         reader.readAsDataURL(blob);  // 转换为base64，可以直接放入a标签href
            //         reader.onload = function (e) {
            //             // 转换完成，创建一个a标签用于下载
            //             var a = document.createElement('a');
            //             //文件名
            //             a.download = '图书信息表（模板）.xlsx';
            //             var url = window.URL.createObjectURL(blob);
            //             // alert(url);
            //             a.href = url;
            //             document.querySelector("body").appendChild(a);  // 修复firefox中无法触发click
            //             a.click();
            //             a.parentNode.remove();
            //         }
            //     }
            // }
            //  xhr.send();
        // })
    </script>
</body>

</html>
