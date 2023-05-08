<?php
    /*
     * 管理员可查询所有人的借阅记录
     * 借阅记录查询模块
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../classes/check_rights.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $usertype = $_SESSION['usertype']; //用户登录时的身份

    $id = $_SESSION['user_id'];
    if($usertype == '学生'){
        $sql = "select * from student where cardNo = '$id'";
    }else if($usertype == '教师'){
        $sql = "select * from teacher where cardNo = '$id'";
    }else if($usertype == '图书管理员'){
        $sql = "select * from lib_worker where id = '$id'";
    }else if($usertype == '超级管理员'){
        $sql = "select * from super_admin where id = '$id'";
    }else{
        $sql = "select * from other_user where id = '$id'";
    }
    $info_res = mysqli_query($db_connect, $sql);

    mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>借阅记录查询</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache, must-revalidate">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        /*大于10天*/
        .have{
            color: #009688;
        }

        /*小于10天*/
        .use{
            color: #ff5722 !important;
        }
        .layui-select-title input{
            text-align: center;
            padding-left: 0;
            height: 45px;
        }

        .statusBar{
            position: fixed;
            bottom: 44px;
            border-style: solid;
            border-color: #eee;
            z-index: 9;
            line-height: 30px;
            width: 100%;
            height: 30px;
            background: #fff;
            color: #ff0000;
            padding-left: 30px;
        }

        #rangDate input{
            height: 45px;
        }

        .layui-form-label{
            height: 45px !important;
            line-height: 27px !important;
            margin-left: 50px;
        }
    </style>
    <script type="text/javascript">
        //禁用复制
        // document.oncopy = function () {
        //     return false;
        // }
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
            <a href="../index">
                <div class="layui-logo layui-bg-black">Library</div>
            </a>
            <!-- 头部区域（可配合layui 已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-hide-xs"><a href="../index">后台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../../index">前台首页</a></li>
                <li class="layui-nav-item layui-hide-xs"><a href="../system/help_guide">帮助文档</a></li>
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
                                echo "<dd><a href='../user_center/user_Info'>个人中心</a></dd>";
                            }
                        ?>
                        <dd><a href="../user_center/update_pwd">修改密码</a></dd>
                        <dd><a href="../../login/logout">注销</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <?php include "../layouts/layout_side.php"; ?>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <fieldset class="layui-elem-field layui-field-title" style="border: 1px solid #C9C9C9;margin: 15px 20px 20px 20px;">
                <legend>借阅记录查询</legend>
                <div class="layui-form layui-form-pane" lay-filter="form_data" style="margin: 20px;display: flex;text-align: center">
                    <div class="layui-form-item" style="width: 120px;">
                        <div class="layui-input-inline" style="width: 120px;">
                            <select name="keywords_type" lay-filter="keys">
                                <option value="0">借阅卡号</option>
                                <option value="1">图书编号</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="width: 400px;margin-right: 10px;">
                            <input style="height: 45px;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入关键词" class="layui-input">
                        </div>
                        <button class="layui-btn" style="height: 43px;" id="search"><i class='layui-icon layui-icon-search'></i> 查询</button>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">日期范围</label>
                        <div class="layui-input-block" id="rangDate" style="width: 350px;">
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" autocomplete="off" name="startDate" id="startDate" class="layui-input" placeholder="开始日期">
                            </div>
                            <div class="layui-form-mid">-</div>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" autocomplete="off" name="endDate" id="endDate" class="layui-input" placeholder="结束日期">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <!--显示查询结果-->
            <table class="layui-hide" id="dataList" lay-filter="tab"></table>
            <script type="text/html" id="barDemo">
                <button class='layui-btn layui-btn-xs' lay-event='detail'>读者信息</button>
            </script>
            <script type="text/html" id="limit">
                <span>{{d.borrow_limitDay}} 天</span>
            </script>
            <script type="text/html" id="left">
                <span class="{{d.left_day >= 10 ? 'have' : 'use'}}">{{d.left_day}} 天</span>
            </script>
            <script type="text/html" id="is_back">
                <span class="{{d.is_back == 0 ? 'use' : 'have'}}">{{d.is_back == 0 ? '阅读中' : '已归还'}}</span>
            </script>
            <script type="text/html" id="mark">
                <span class="use">{{d.mark}}</span>
            </script>
            <div class="statusBar">共计：<span class="num"></span> 条</div>
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
    <script type="text/javascript">
        layui.use(['table', 'form', 'util', 'laydate'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,table = layui.table
                ,laydate = layui.laydate
                ,form = layui.form;

            // 创建渲染实例
            table.render({
                elem: '#dataList',
                type: 'POST',
                url: '../../controllers/books_circulation/record_data',
                parseData: function(res) { //res 即为原始返回的数据
                    // console.log(res); //打印数据显示
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.msg, //解析提示文本
                        "count": res.count, //解析数据长度
                        "data": res.data, //解析数据列表
                    }
                },
                response: {
                    statusCode: 200, //规定成功的状态码，默认：0
                },
                height: 'full-301', // 最大高度减去其他容器已占有的高度差
                cellMinWidth: 100,
                page: false, //开启分页
                even: true, //隔行换色
                loading: true,
                text: {
                    none: '暂无数据'
                },
                cols: [
                    [{
                        field: 'card_id',
                        fixed: 'left',
                        width: 130,
                        title: '借阅卡号',
                        align: 'center'
                    }, {
                        field: 'book_id',
                        width: 130,
                        title: '图书编号',
                        align: 'center'
                    }, {
                        field: 'book_name',
                        width: 300,
                        title: '图书名称',
                        align: 'center'
                    }, {
                        field: 'book_price',
                        title: '价格（元）',
                        width: 100,
                        align: 'center'
                    }, {
                        field: 'borrow_limitDay',
                        width: 100,
                        title: "借阅期限",
                        align: 'center',
                        templet: '#limit'
                    }, {
                        field: 'left_day',
                        width: 110,
                        title: "距离到期",
                        align: 'center',
                        sort: true,
                        templet: '#left'
                    }, {
                        field: 'is_back',
                        width: 110,
                        title: '是否归还',
                        align: 'center',
                        sort: true,
                        templet: '#is_back'
                    }, {
                        field: 'mark',
                        width: 130,
                        title: '备注',
                        align: 'center',
                        templet: '#mark'
                    }, {
                        field: 'do_backDate',
                        width: 160,
                        title: '归还日期',
                        align: 'center'
                    }, {
                        field: 'borrow_date',
                        width: 160,
                        title: '借书日期',
                        align: 'center'
                    }, {
                        field: 'back_date',
                        width: 160,
                        title: '应还日期',
                        align: 'center'
                    }, {
                        field: 'renew_backDate',
                        width: 160,
                        title: '续借后应还日期',
                        align: 'center'
                    }, {
                        field: 'renew_num',
                        width: 120,
                        title: '续借次数',
                        sort: true,
                        align: 'center'
                    },  {
                        fixed: 'right',
                        width: 120,
                        title: '操作',
                        align: 'center',
                        toolbar: '#barDemo'
                    }]
                ],
                done: function (res, curr, count){
                    // console.log(res);
                    $('.num').text(res.count);  //所有借阅记录条数
                },
                error: function(res, msg) {
                    console.log(res, msg)
                }
            });

            //触发单元格工具事件
            table.on('tool(tab)', function(obj) {
                let data = obj.data;
                // console.log(data);
                let card_id = data.card_id;  //读者借阅卡号
                let url = '../books_circulation/borrow_detail?card_id='+card_id;
                // console.log(obj);
                if (obj.event === 'detail') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-about"></i> 读者信息',
                        type: 2,
                        area: ['580px', '530px'],
                        skin: 'layui-layer-molv',
                        scrollbar: false,
                        move: false,
                        shadeClose: true,
                        content: url,
                        success: function (){
                            // layer.close();
                        }
                    })
                }
            })

            // 搜索功能
            function search(){
                let data = form.val('form_data');
                // console.log(data);
                let keywords = $.trim(data.keywords);  //搜索关键词
                let keywords_type = $.trim(data.keywords_type);  //搜索类型
                // console.log(keywords);
                if(keywords === ''){
                    layer.msg('请输入关键词', {
                        time: 2000
                    })
                    $('#key').focus();
                }else {
                    $.ajax({
                        url: '../../controllers/books_circulation/record_data',
                        type: 'GET',
                        data: {
                            keywords: keywords,
                            keywords_type: keywords_type
                        },
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            if (res.code === 200) {
                                if(res.count === 0){
                                    layer.msg('无记录', {
                                        icon: 7,
                                        shade: .2,
                                        time: 2000
                                    }, function (){
                                        // $('#key').val('');  //搜索不到时清空搜索框
                                    })
                                    table.reload('dataList', {
                                        where: {
                                            keywords: '',
                                            keywords_type: ''
                                        }
                                    })
                                }else{
                                    table.reload('dataList', {
                                        page: false,
                                        where: {
                                            keywords: keywords,
                                            keywords_type: keywords_type
                                        }
                                    })
                                }
                            }
                        }
                    })
                }
            }

            //搜索
            $('#search').on('click', function (){
                search();
            })

            //绑定enter回车搜索
            $(document).keyup(function (event) {
                if (event.keyCode == '13') {
                    search();
                }
            })

            //切换搜索类型时清除内容
            form.on("select(keys)",function(value){
                $('#key').val('');
                //清除表格数据
                table.reload('dataList', {
                    where: {
                        keywords: '',
                        keywords_type: ''
                    }
                })
            })

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

            let startDate = '';
            let endDate = '';
            //选择日期范围
            laydate.render({
                elem: '#startDate',
                min: -365,  //过去一年内
                max: today,  //最大日期不能大于当天，也就是不能查询未来的数据
                value: today, //赋予初始值，当前日期
                done: function(value) {
                    startDate = value;
                    // console.log(value)
                    laydate.render({
                        elem: '#endDate',
                        min: startDate,  //必须始终大于开始时间
                        max: today,  //最大日期不能大于当天，也就是不能查询未来的数据
                        done: function (value){
                            endDate = value;
                            // console.log(value); //选择的日期
                            // console.log(startDate);
                            // console.log(endDate);

                            // 根据选择的日期范围搜索记录
                            $.ajax({
                                url: '../../controllers/books_circulation/record_data',
                                type: 'GET',
                                data: {
                                    startDate: startDate, //开始时间
                                    endDate: endDate,  //结束时间
                                    keywords_type: 3
                                },
                                dataType: 'json',
                                success: function (res) {
                                    console.log(res);
                                    if (res.code === 200) {
                                        if(res.count === 0){
                                            layer.msg('该日期范围内无记录', {
                                                icon: 7,
                                                shade: .2,
                                                time: 2000
                                            }, function (){
                                                // $('#key').val('');  //搜索不到时清空搜索框
                                            })
                                            table.reload('dataList', {
                                                where: {
                                                    startDate: '', //开始时间
                                                    endDate: '',  //结束时间
                                                    keywords_type: 3
                                                }
                                            })
                                        }else{
                                            table.reload('dataList', {
                                                page: false,
                                                where: {
                                                    startDate: startDate, //开始时间
                                                    endDate: endDate,  //结束时间
                                                    keywords_type: 3
                                                }
                                            })
                                        }
                                    }
                                }
                            })
                        }
                    })
                }
            })

            // 初始化结束日期
            laydate.render({
                elem: '#endDate',
                min: startDate,  //必须始终大于开始时间
                max: today,  //最大日期不能大于当天，也就是不能查询未来的数据
                done: function (value){
                    // console.log(value); //选择的日期
                }
            })
        })
    </script>
</body>

</html>
