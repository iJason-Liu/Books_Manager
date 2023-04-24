<?php
    /*
     * 图书类别模块，可增加删除修改
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }else if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $usertype = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select type_id from user_type where usertype_name='$usertype'";
    $res = mysqli_query($db_connect, $check_sql);

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>图书分类</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="pragma" content="no-cache">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        /*隐藏功能*/
        .show {
            display: block !important;
        }

        .hide {
            display: none !important;
        }
    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function () {
            return false;
        }
        //禁用浏览器右键点击事件
        document.oncontextmenu = function () {
            return false;
        }
        //禁止拖拽
        document.ondragstart = function () {
            return false
        }
        //禁止用户选中网页上的内容
        // document.onselectstart=function(){return false}
        //禁用复制剪贴版
        document.onbeforecopy = function () {
            return false
        }
        //禁用文本框或者文本域中的文字被选中
        // document.onselect=function(){return false;}
    </script>
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <a href="../index.php">
                <div class="layui-logo layui-bg-black">Library</div>
            </a>
            <!-- 头部区域（可配合layui 已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-hide-xs"><a href="../index.php">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../../index.php">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide.php">帮助中心</a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item layui-hide-xs layui-show-md-inline-block">
                    <a href="javascript:;">
                        <img src="<?php echo $_SESSION['avatar'] ?>" class="layui-nav-img">
                        <?php
                            echo "您好！". $_SESSION['user'];
                        ?>
                    </a>
                    <dl class="layui-nav-child layui-nav-child-c">
                        <?php
                            if($usertype != '超级管理员'){
                                echo "<dd><a href='../user_center/user_Info.php'>个人中心</a></dd>";
                            }
                        ?>
                        <dd><a href="../user_center/update_pwd.php">修改密码</a></dd>
                        <dd><a href="../../login/logout.php">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <?php include "../layouts/layout_side.php"; ?>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <table class="layui-hide" id="dataList" lay-filter="tab"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class='layui-btn layui-btn-sm' lay-event='add'><i class='layui-icon layui-icon-addition'></i>添加</button>
                    <button class='layui-btn layui-btn-sm layui-btn-danger' lay-event='del'><i class='layui-icon layui-icon-delete'></i>删除</button>
                </div>
            </script>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <p style="text-align: center;">
                Copyright © 2023 by Jason Liu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://beian.miit.gov.cn/" target="_blank"><img src="../../skin/images/beian.png" alt=""/>滇ICP备2023001154号-1</a>
                <!-- <a target="_blank" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=53252702252753"><img src="../images/beian.png" alt=""/> 滇公网安备 53252702252753号</a>-->
            </p>
        </div>
    </div>

    <script src="../../skin/js/layui.min.js"></script>
    <script>
        let usertype = '<?php echo $usertype ?>'; //用户身份
        layui.use(['table', 'layer'], function() {
            let $ = layui.jquery
                , layer = layui.layer
                , table = layui.table;

            // 创建渲染实例
            table.render({
                elem: '#dataList',
                type: 'POST',
                url: '../../controllers/books_center/book_kindData.php',
                parseData: function(res) { //res 即为原始返回的数据
                    // console.log(res); //打印数据显示
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.msg, //解析提示文本
                        "data": res.data, //解析数据列表
                    }
                },
                response: {
                    statusCode: 200, //规定成功的状态码，默认：0
                },
                toolbar: '#toolbarDemo',
                height: 'full-106', // 最大高度减去其他容器已占有的高度差
                even: true, //隔行换色
                loading: true,
                defaultToolbar: ['exports'],
                text: {
                    none: '暂无数据'
                },
                cols: [
                    [{
                        type: 'checkbox',
                        fixed: 'left'
                    }, {
                        field: 'type_id',
                        width: 180,
                        title: '编号',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'type_name',
                        minwidth: 360,
                        title: "<i class='layui-icon layui-icon-edit'></i>类别名称（可编辑）",
                        align: 'left',
                        edit: 'text'
                    }, {
                        field: 'mark',
                        minwidth: 180,
                        title: "<i class='layui-icon layui-icon-edit'></i>备注",
                        align: 'left',
                        edit: 'text'
                    }]
                ],
                done: function (res, curr, count){
                    // console.log(res);
                },
                error: function(res, msg) {
                    console.log(res, msg)
                }
            });

            // 工具栏事件
            table.on('toolbar(tab)', function(obj) {
                let id = obj.config.id;
                let checkStatus = table.checkStatus(id);
                // 获取选中的数据
                let data = checkStatus.data;
                let arr_id = [];  //选中的图书类别id
                let num = data.length; //选中的数量
                //把选中的图书类别id添加在一个数组中
                data.map(function (item){
                    arr_id.push(item.type_id);
                })
                // console.log(checkStatus);
                // console.log(arr_id);
                switch (obj.event) {
                    case 'del':
                        if(data.length === 0){
                            layer.msg('请至少选择一项~',{
                                time: 1500
                            });
                        }else {
                            layer.confirm('确认删除这 ' + num + ' 个分类吗？',{title: '温馨提示'}, function (index) {
                                $.ajax({
                                    url: '../../controllers/books_center/delete_book_kind.php',
                                    type: 'POST',
                                    data: JSON.stringify(arr_id),
                                    dataType: 'json',
                                    success: function (res){
                                        // console.log(res);
                                        if(res.code === 200){
                                            layer.msg(res.msg, {
                                                // icon: 1,
                                                time: 1500
                                            },function (){
                                                table.reload('dataList',{},true) //表格数据重载
                                            })
                                        }else{
                                            layer.msg(res.msg, {
                                                icon: 7,
                                                anim: 6,
                                                time: 1500
                                            })
                                        }
                                    }
                                })
                                layer.close(index); //点击确认后关闭窗口
                            }, function () {
                                // layer.msg('取消操作', {
                                //     // icon: 7,
                                //     time: 1000, //1s后自动关闭
                                // })
                            })
                        }
                        break;
                    case 'add':
                        layer.open({
                            title: '<i class="layui-icon layui-icon-addition"></i>新增分类',
                            type: 2,
                            area: ['35%', '60%'],
                            skin: 'layui-layer-molv',
                            shadeClose: true, //点击遮罩关闭=窗口
                            content: '../books_center/add_book_kind.php'
                        })
                        break;
                }
            })

            // 单元格编辑事件
            table.on('edit(tab)', function(obj) {
                // console.log(obj);
                let field = obj.field, //得到字段
                    value = obj.value, //得到修改后的值
                    data = obj.data; //得到所在行所有键值
                // console.log(field);
                if(usertype === '学生' || usertype === '教师'){
                    //添加disabled
                    layer.msg('禁止操作！',{
                        time: 1000
                    }, function (){
                        table.reload('dataList');
                    })
                    return false;
                }else {
                    $.ajax({
                        type: "POST",
                        url: '../../controllers/books_center/editUnit.php',
                        data: {
                            'id': data.type_id,
                            'type_name': value,  //分类名称
                            'desc': value,  //备注
                            'field': field,  //字段名
                            'type': 1  //图书分类
                        },
                        dataType: 'json',
                        success: function (res) {
                           if(res.code === 200){
                                layer.msg(res.msg,{
                                    time: 1000
                                })
                           }else{
                                layer.msg(res.msg,{
                                    icon: 7,
                                    anim: 6,
                                    time: 1000
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
