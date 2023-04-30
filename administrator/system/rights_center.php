<?php
    /*
     * 系统权限管理
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

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>权限管理</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        #laypage{
            position: fixed;
            bottom: 42px;
            border-style: solid;
            border-color: #eee;
            z-index:999;
            width: 100%;
            background: #fff;
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
                <legend>用户查询</legend>
                <div class="layui-form layui-form-pane" lay-filter="form_data" style="margin: 20px;">
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="margin-top: -1px;width: 360px;margin-right: 10px;">
                          <input style="height: 45px;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入账号或用户名" class="layui-input">
                        </div>
                        <button class="layui-btn" style="height: 43px;" id="search"><i class='layui-icon layui-icon-search'></i> 搜索</button>
                    </div>
                </div>
            </fieldset>

            <table class="layui-hide" id="dataList" lay-filter="tab"></table>
            <script type="text/html" id="barDemo">
                <a class='layui-btn layui-btn-xs' lay-event='edit'>权限设置</a>
            </script>
            <div id="laypage"></div>
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
        layui.use(['table', 'laypage', 'form'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,table = layui.table
                ,form = layui.form
                ,laypage = layui.laypage
                ,pageNo = 1  //当前页码
                ,pageSize = 10;  //每页条数

            let data = form.val('form_data');
            let keywords = $.trim(data.keywords);
            let keywords_type = data.keywords_type;

            // 创建渲染实例
            table.render({
                elem: '#dataList',
                type: 'POST',
                url: '../../controllers/system/getRights',
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
                where: { //接口参数，page为分页参数
                    page: pageNo,
                    limit: pageSize,
                    keywords: keywords,
                    keywords_type: keywords_type
                },
                height: 'full-308', // 最大高度减去其他容器已占有的高度差
                // totalRow: true, // 开启合计行
                page: false, //开启分页
                even: true, //隔行换色
                loading: true,
                text: {
                    none: '暂无数据'
                },
                cols: [
                    [{
                        type: 'checkbox',
                        fixed: 'left',
                        hide: true
                    }, {
                        field: 'id',
                        fixed: 'left',
                        width: 150,
                        title: '账号',
                        sort: true,
                        align: 'center'
                    },{
                        field: 'user_name',
                        minwidth: 200,
                        title: '用户名',
                        align: 'center'
                    },{
                        field: 'user_type',
                        minwidth: 170,
                        title: "用户类型",
                        align: 'left'
                    }, {
                        fixed: 'right',
                        title: '操作',
                        width: 120,
                        align: 'center',
                        toolbar: '#barDemo'
                    }]
                ],
                done: function (res, curr, count){
                    // console.log(res);
                    //在获取到表格数据后加载分页组件，点击分页时调用table的reload方法重新加载表格数据达到分页效果
                    laypage.render({
                        elem: 'laypage', //分页容器ID
                        count: res.count, //通过后台拿到总页数
                        curr: pageNo, //当前页码
                        limit: pageSize, //分页大小
                        limits: [10,20,30,50],
                        groups: 3,  //连续出现的页码数
                        layout: ['prev', 'page', 'next', 'skip', 'count', 'limit'],
                        jump: function (obj, first) {  //跳转方法
                            // console.log(obj);
                            let data = form.val('form_data');
                            let keywords = $.trim(data.keywords);
                            if (!first) {  //若不为第一页
                                pageNo = obj.curr;  //设置全局变量page 为当前选择页码
                                pageSize = obj.limit;  //设置全局变量limit 为当前选择分页大小
                                table.reload('dataList', { //重新加载表格
                                    where: {   //接口参数，page为分页参数
                                        page: pageNo,
                                        limit: pageSize,
                                        keywords: keywords,
                                        keywords_type: data.keywords_type
                                    }
                                })
                            }
                        }
                    })
                },
                error: function(res, msg) {
                    console.log(res, msg)
                }
            });

            //触发单元格工具事件
            table.on('tool(tab)', function(obj) {
                let data = obj.data;
                //console.log(data);
                let id = data.id;
                // 编辑内容url
                let url = '../system/set_rights?id='+id;
                // console.log(obj);
                if (obj.event === 'edit') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-edit"></i> 权限设置',
                        type: 2,
                        area: ['620px', '520px'],
                        content: url,
                        // btn: ['确认','取消'],
                        skin: 'layui-layer-molv',
                        // maxmin: true,
                        scrollbar: false,
                        // shadeClose: true,
                        success: function (){
                            // layer.close();
                        }
                    })
                }
            })

            //搜索用户
            function search(){
                let data = form.val('form_data');
                let keywords = data.keywords;
                // console.log(keywords);
                if(keywords === ''){
                    layer.msg('请输入关键词',{
                        time: 2000
                    })
                    $('#key').focus();
                }else {
                    table.reload('dataList', {
                        url: '../../controllers/system/search_user',
                        page: false, //开启分页
                        where: {
                            keywords: keywords,
                            keywords_type: data.keywords_type
                        }
                    })
                }
            }
            //点击按钮搜索
            $('#search').on('click', function (){
                search();
            })

            //绑定enter回车搜索
            $(document).keyup(function (event) {
                if (event.keyCode == '13') {
                    search();
                }
            })

            //监听当输入框等于空时自动渲染全部数据
            $('#key').bind('input property-change', function (obj){
                let data = form.val('form_data');
                let keywords = data.keywords;
                if(keywords === ''){
                    table.reload('dataList',{
                        url: '../../controllers/system/getRights',
                        page: false, //开启分页
                        where: {
                            keywords: keywords
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>
