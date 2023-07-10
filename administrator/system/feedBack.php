<?php
    /*
     * 意见建议反馈查看中心
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../classes/check_rights.php';
    include '../../oauth/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $usertype = $_SESSION['usertype']; //用户登录时的身份

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>反馈查看中心</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        .layui-table-view-1 .layui-table-body .layui-table .layui-table-cell{
            height: 80px;
            line-height: 80px;
        }
        .mark{
            width: 270px;
            height: 64px;
        }
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
                <li class="layui-nav-item layui-hide-xs"><a href="../../upload/pdf/小新图书馆操作指南.pdf" target="_blank">操作指南</a></li>
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
                        <dd><a href="../../oauth/logout">注销</a></dd>
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
                    <button class='layui-btn layui-btn-sm layui-btn-danger' lay-event='del'><i class='layui-icon layui-icon-delete'></i>删除</button>
                </div>
            </script>
            <script type="text/html" id="barDemo">
                <a class='layui-btn layui-btn-xs' lay-event='detail'>查看</a>
            </script>
            <script type="text/html" id="user_id">
                <span>{{d.user_id == '' || d.user_id == null ? '游客' : d.user_id}}</span>
            </script>
            <script type="text/html" id="user_name">
                <span>{{d.user_name == '' || d.user_name == null ? '游客' : d.user_name}}</span>
            </script>
            <script type="text/html" id="content">
                <div class="mark" title="{{d.content}}">{{d.content}}</div>
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
        layui.use(['table', 'layer', 'laypage'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,table = layui.table
                ,laypage = layui.laypage
                ,pageNo = 1  //当前页码
                ,pageSize = 10;  //每页条数;

            // 创建渲染实例
            table.render({
                elem: '#dataList',
                type: 'POST',
                url: '../../controllers/system/getFeedback',
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
                    limit: pageSize
                },
                toolbar: '#toolbarDemo',
                height: 'full-159', // 最大高度减去其他容器已占有的高度差
                even: true, //隔行换色
                loading: true,
                // skin: 'line',  //行边框样式
                defaultToolbar: ['exports'],
                title: '意见建议反馈表', //表格名称
                text: {
                    none: '暂无数据'
                },
                cols: [
                    [{
                        type: 'checkbox',
                        fixed: 'left'
                    }, {
                        field: 'id',
                        width: 100,
                        title: '序号',
                        sort: true,
                        fixed: 'left',
                        align: 'center'
                    },
                    //     {
                    //     field: 'user_id',
                    //     width: 150,
                    //     title: "用户ID",
                    //     align: 'center',
                    //     templet: '#user_id'
                    // },
                        {
                        field: 'user_name',
                        width: 120,
                        title: "用户名",
                        align: 'center',
                        templet: '#user_name'
                    }, {
                        field: 'content',
                        minwidth: 300,
                        title: "反馈内容",
                        align: 'center',
                        templet: '#content'
                    }, {
                        field: 'sub_time',
                        width: 160,
                        title: "提交时间",
                        sort: true,
                        align: 'center'
                    }, {
                        toolbar: '#barDemo',
                        width: 110,
                        title: "操作",
                        align: 'center',
                        fixed: 'right'
                    }]
                ],
                done: function (res, curr, count){
                    // console.log(res);
                    $('.num').text(res.count);  //所有评论条数
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
                            if (!first) {  //若不为第一页
                                pageNo = obj.curr;  //设置全局变量page 为当前选择页码
                                pageSize = obj.limit;  //设置全局变量limit 为当前选择分页大小
                                table.reload('dataList', { //重新加载表格
                                    where: {   //接口参数，page为分页参数
                                        page: pageNo,
                                        limit: pageSize
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

            // 工具栏事件
            table.on('toolbar(tab)', function(obj) {
                let id = obj.config.id;
                let checkStatus = table.checkStatus(id);
                // 获取选中的数据
                let data = checkStatus.data;
                // console.log(data);
                let arr_id = [];  //选中的反馈记录id
                let num = data.length; //选中的数量
                //把选中的反馈记录id添加在一个数组中
                data.map(function (item){
                    arr_id.push(item.id);
                })
                // console.log(arr_id);
                switch (obj.event) {
                    case 'del':
                        if(data.length === 0){
                            layer.msg('请至少选择一项~',{
                                time: 1500
                            })
                        }else {
                            layer.confirm('是否确认删除这 ' + num + ' 条反馈记录？',{title: '温馨提示'}, function (index) {
                                $.ajax({
                                    url: '../../controllers/system/delete_feedbacks',
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
                                                table.reload('dataList',{},true) //表格数据重载
                                            })
                                        }else{
                                            layer.msg(res.msg, {
                                                icon: 7,
                                                shade: .2,
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
                }
            })

            //触发单元格工具事件
            table.on('tool(tab)', function(obj) {
                let data = obj.data;
                //console.log(data);
                let id = data.id;  //反馈id
                // 编辑内容url
                let url = '../system/feedback_detail?id='+id;
                // console.log(obj);
                if (obj.event === 'detail') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-note"></i> 查看详情',
                        type: 2,
                        area: ['680px', '600px'],
                        content: url,
                        // btn: ['确认','取消'],
                        skin: 'layui-layer-molv',
                        maxmin: true,
                        move: false,
                        scrollbar: false,
                        // shadeClose: true,
                        success: function (){
                            // layer.close();
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>
