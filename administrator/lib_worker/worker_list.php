<?php
    /*
     * 馆员档案模块
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../classes/check_rights.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login'</script>";
    }

    $usertype = $_SESSION['usertype']; //用户登录时的身份
    
?>

<!DOCTYPE html>
<html>

<head>
    <title>馆员档案</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../../skin/css/layui.min.css">
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
            <fieldset class="layui-elem-field layui-field-title" style="border: 1px solid #C9C9C9;margin: 15px 20px 0 20px;">
                <legend>馆员查询</legend>
                <div class="layui-form layui-form-pane" lay-filter="form_data" style="margin: 20px;">
                    <div class="layui-form-item">
                        <!--<label class="layui-form-label" style="height: 45px;">账号或姓名</label>-->
                        <div class="layui-input-inline" style="margin-top: -1px;width: 360px;margin-right: 10px;">
                          <input style="height: 45px;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入账号或姓名" class="layui-input">
                        </div>
                        <button class="layui-btn" style="height: 43px;" id="search"><i class='layui-icon layui-icon-search'></i> 搜索</button>
                    </div>
                </div>
            </fieldset>

            <table class="layui-hide" id="dataList" lay-filter="test"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class='layui-btn layui-btn-sm' lay-event='addPerson'><i class='layui-icon layui-icon-add-1'></i>新增</button>
                    <button class='layui-btn layui-btn-sm' lay-event='importPerson'><i class='layui-icon layui-icon-add-1'></i>批量导入</button>
                    <button class='layui-btn layui-btn-sm layui-btn-danger' lay-event='delPerson'><i class='layui-icon layui-icon-delete'></i>删除</button>
                </div>
            </script>
            <script type="text/html" id="barDemo">
                <a class='layui-btn layui-btn-xs' lay-event='edit'>编辑</a>
            </script>

            <script type="text/html" id="password">
                <i class='layui-icon layui-icon-password'></i> <input disabled style="border: none;background: none;" type="password" class="pwdType" value="{{d.password}}" />
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
                url: '../../controllers/lib_worker/worker_listData',
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
                toolbar: '#toolbarDemo',
                height: 'full-289', // 最大高度减去其他容器已占有的高度差
                cellMinWidth: 100,
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
                        fixed: 'left'
                    }, {
                        field: 'id',
                        fixed: 'left',
                        width: 130,
                        title: '账号',
                        sort: true,
                        align: 'center'
                    },{
                        field: 'name',
                        width: 170,
                        title: '姓名',
                        align: 'center'
                    },{
                        field: 'password',
                        width: 320,
                        title: "<img style='width: 24px;height: 16px;cursor: pointer;margin-top: -1px;' title='显示' class='showPwd' src='../../skin/images/showPwd.png' />密码",
                        align: 'center',
                        templet: '#password'
                    }, {
                        field: 'sex',
                        width: 120,
                        title: '性别',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'mobile',
                        width: 190,
                        title: '联系电话',
                        align: 'center'
                    }, {
                        field: 'user_type',
                        width: 180,
                        title: '身份类别',
                        align: 'center'
                    }, {
                        field: 'borrow_limit',
                        width: 140,
                        title: '可借图书数量(本)',
                        align: 'center'
                    }, {
                        field: 'createtime',
                        width: 190,
                        title: '注册时间',
                        sort: true,
                        align: 'center',
                    }, {
                        field: 'updatetime',
                        width: 190,
                        title: '修改时间',
                        sort: true,
                        align: 'center',
                    }, {
                        fixed: 'right',
                        title: '操作',
                        width: 100,
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

                    $('.showPwd').on('click', function (){
                        let flag = $('.pwdType').attr('type');
                        if(flag === 'password'){
                            $('.pwdType').attr('type', 'text');
                            $('.showPwd').attr('title', '隐藏');
                        }else{
                            $('.pwdType').attr('type', 'password');
                            $('.showPwd').attr('title', '显示');
                        }
                    })
                },
                error: function(res, msg) {
                    console.log(res, msg)
                }
            });

            // 工具栏事件
            table.on('toolbar(test)', function(obj) {
                let id = obj.config.id;
                let checkStatus = table.checkStatus(id);
                // 获取选中的数据
                let data = checkStatus.data;
                let arr_id = [];  //选中的馆员id
                let num = data.length; //选中的数量
                //把选中的馆员id添加在一个数组中
                data.map(function (item){
                    arr_id.push(item.id);
                })
                // console.log(arr_id);
                switch (obj.event) {
                    case 'delPerson':
                        if(data.length === 0){
                            layer.msg('请至少选择一项~',{
                                time: 1500
                            });
                        }else {
                            layer.confirm('是否确认删除这 ' + num + ' 个馆员？',{title: '温馨提示'}, function (index) {
                                $.ajax({
                                    url: '../../controllers/lib_worker/delete_workers',
                                    type: 'POST',
                                    data: JSON.stringify(arr_id),
                                    dataType: 'json',
                                    success: function (res){
                                        // console.log(res);
                                        if(res.code === 200){
                                            layer.msg(res.msg, {
                                                icon: 6,
                                                shade: .2,
                                                time: 2000
                                            },function (){
                                                let current = 0; //初始化
                                                if(pageSize - num === 0){
                                                    current = 1;
                                                }else {
                                                    current = 0;
                                                }
                                                table.reload('dataList',{
                                                    url: '../../controllers/lib_worker/worker_listData',
                                                    where: {   //接口参数，page为分页参数
                                                        page: pageNo-current, //删除整页的时候页面-1
                                                        limit: pageSize
                                                    }
                                                },true) //表格数据重载
                                            })
                                        }else{
                                            layer.msg(res.msg, {
                                                icon: 7,
                                                shade: .2,
                                                time: 2000
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
                    case 'addPerson':
                        layer.open({
                            title: '<i class="layui-icon layui-icon-add-1"></i>新增馆员',
                            type: 2,
                            area: ['640px', '590px'],
                            skin: 'layui-layer-molv',
                            maxmin: true,
                            move: false,
                            // shadeClose: true, //点击遮罩关闭=窗口
                            content: '../lib_worker/add_person'
                        })
                        break;
                    case 'importPerson':
                        layer.open({
                            title: '<i class="layui-icon layui-icon-add-1"></i>批量导入馆员',
                            type: 2,
                            area: ['48%', '85%'],
                            skin: 'layui-layer-molv',
                            content: '../../classes/import_data?import_type=1'  //type 1 馆员
                        })
                        break;
                }
            })

            //触发单元格工具事件
            table.on('tool(test)', function(obj) {
                let data = obj.data;
                // console.log(data);
                let id = data.id;
                // 编辑内容url
                let url = '../lib_worker/update_worker?id='+id;
                // console.log(obj);
                if (obj.event === 'edit') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-edit"></i> 编辑馆员信息',
                        type: 2,
                        area: ['48%', '88%'],
                        content: url,
                        // btn: ['确认','取消'],
                        skin: 'layui-layer-molv',
                        maxmin: true,
                        scrollbar: false,
                        // shadeClose: true,
                        success: function (){
                            // layer.close();
                        }
                    })
                }
            })

            //搜索内容
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
                        url: '../../controllers/lib_worker/search_workerData',
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
                        url: '../../controllers/lib_worker/worker_listData',
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