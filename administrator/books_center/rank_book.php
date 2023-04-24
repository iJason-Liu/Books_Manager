<?php
    /*
     * 人气图书模块
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
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
    <title>人气图书</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="pragma" content="no-cache">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
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
        /*大于3次*/
        .strong{
            color: #ff5722;
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
                    <button class='layui-btn layui-btn-sm layui-btn-primary' lay-event='sunshine' id='sunshine'><i class='layui-icon layui-icon-diamond'></i></button>
                    <button class='layui-btn layui-btn-sm'><?php echo date('Y-m-d') ?></button>
                </div>
            </script>
            <script type="text/html" id="b_num">
                <span class="{{d.borrow_num >= 3 ? 'strong' : ''}}">{{d.borrow_num}}</span>
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
                url: '../../controllers/books_center/rank_booksData.php',
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
                        field: 'book_id',
                        width: 180,
                        title: '编号',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'book_name',
                        minwidth: 360,
                        title: "图书名称",
                        align: 'center'
                    }, {
                        field: 'click_num',
                        width: 160,
                        title: "浏览次数",
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'borrow_num',
                        width: 160,
                        title: "借阅次数",
                        sort: true,
                        align: 'center',
                        templet: '#b_num'
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
                switch (obj.event) {
                    case 'sunshine':
                        layer.tips('书中自有黄金屋，书中自有颜如玉。', '#sunshine',{
                            tips: [2,'#666'],
                            time: 1500
                        });
                        break;
                }
            })
        })
    </script>
</body>
</html>
