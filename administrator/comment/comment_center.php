<?php
    /*
     * 评论中心，评论管理模块，进行审核删除等操作
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
    <title>评论中心</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        .have{
            color: #009688;
        }
        .use{
            color: #ff5722;
        }
        /*.statusBar{*/
        /*    position: fixed;*/
        /*    bottom: 96px;*/
        /*    border-style: solid;*/
        /*    border-color: #eee;*/
        /*    z-index: 9;*/
        /*    line-height: 30px;*/
        /*    width: 100%;*/
        /*    height: 30px;*/
        /*    background: #fff;*/
        /*    color: #ff0000;*/
        /*    padding-left: 30px;*/
        /*}*/
        .layui-table-view-1 .layui-table-body .layui-table .layui-table-cell{
            height: 100px;
            line-height: 100px;
        }
        .mark{
            width: 270px;
            height: 84px;
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
            <table class="layui-hide" id="dataList" lay-filter="tab"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class='layui-btn layui-btn-sm' lay-event='check'><i class='layui-icon layui-icon-note'></i> 审核评论</button>
                    <button class='layui-btn layui-btn-sm layui-btn-danger' lay-event='del'><i class='layui-icon layui-icon-delete'></i>删除</button>
                </div>
            </script>
            <script type="text/html" id="avatar">
                <img style="width: 72px;height: 72px;border-radius: 50%;margin-top: -15px;" src="{{d.avatar}}">
            </script>
            <script type="text/html" id="content">
                <div class="mark" title="{{d.content}}">{{d.content}}</div>
            </script>
            <script type="text/html" id="status">
                <span class="{{d.approve_status == 2 ? 'use' : 'have'}}">{{d.approve_status == 0 ? '待审核' : (d.approve_status == 1 ? '审核通过' : '审核未通过')}}</span>
            </script>
            <div id="laypage"></div>
            <!--<div class="statusBar">共计：<span class="num"></span> 条</div>-->
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
                url: '../../controllers/comment/comment_listData',
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
                skin: 'line',  //行边框样式
                defaultToolbar: ['exports'],
                title: '用户评论表（书评）', //表格名称
                text: {
                    none: '暂无数据'
                },
                cols: [
                    [{
                        type: 'checkbox',
                        fixed: 'left'
                    }, {
                        field: 'comment_id',
                        width: 100,
                        title: '序号',
                        sort: true,
                        fixed: 'left',
                        align: 'center'
                    }, {
                        field: 'avatar',
                        width: 150,
                        title: "头像",
                        align: 'center',
                        templet: '#avatar'
                    }, {
                        field: 'user_name',
                        width: 120,
                        title: "用户名",
                        align: 'center'
                    }, {
                        field: 'book_name',
                        width: 300,
                        title: "评论图书",
                        align: 'center'
                    }, {
                        field: 'content',
                        width: 300,
                        title: "评论内容",
                        align: 'center',
                        templet: '#content'
                    }, {
                        field: 'createtime',
                        width: 160,
                        title: "评论时间",
                        align: 'center'
                    }, {
                        field: 'star',
                        width: 120,
                        title: "点赞次数",
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'approve_content',
                        width: 200,
                        title: "审核内容",
                        align: 'center'
                    }, {
                        field: 'approve_time',
                        width: 180,
                        title: "审核时间",
                        align: 'center'
                    }, {
                        field: 'approve_status',
                        width: 120,
                        title: "审核状态",
                        fixed: 'right',
                        align: 'center',
                        sort: true,
                        templet: '#status'
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
                let arr_id = [];  //选中的评论id
                let num = data.length; //选中的数量
                //把选中的评论id添加在一个数组中
                data.map(function (item){
                    arr_id.push(item.comment_id);
                })
                // console.log(arr_id);
                switch (obj.event) {
                    case 'del':
                        if(data.length === 0){
                            layer.msg('请至少选择一项~',{
                                time: 1500
                            })
                        }else {
                            layer.confirm('是否确认删除这 ' + num + ' 条评论？',{title: '温馨提示'}, function (index) {
                                $.ajax({
                                    url: '../../controllers/comment/delete_comments',
                                    type: 'POST',
                                    data: JSON.stringify(arr_id),
                                    dataType: 'json',
                                    success: function (res){
                                        // console.log(res);
                                        if(res.code === 200){
                                            layer.msg(res.msg, {
                                                icon: 1,
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
                    case 'check':
                        if(data.length === 0){
                            layer.msg('请选择一条评论',{
                                time: 1500
                            })
                        }else if(data.length > 1){
                            layer.msg('一次暂只能审核一条评论',{
                                time: 2000
                            })
                        }else {
                            let approve_status = data[0].approve_status; //单条评论的审核状态
                            let comment_id = data[0].comment_id; //单条评论id
                            let url = "../comment/check_comment?comment_id="+comment_id;
                            if(approve_status == 1 || approve_status == 2){
                                layer.confirm('该条评论已审核，继续操作将修改审批结果！',{title: '系统提示', icon: 7}, function(index){
                                    layer.open({
                                        title: '<i class="layui-icon layui-icon-survey"></i> 评论审核',
                                        type: 2,
                                        area: ['620px', '580px'],
                                        skin: 'layui-layer-molv',
                                        move: false,
                                        scrollbar: false,
                                        shadeClose: false, //点击遮罩关闭=窗口
                                        content: url
                                    })
                                    layer.close(index); //点击确认后关闭窗口
                                })
                            }
                        }
                        break;
                }
            })
        })
    </script>
</body>

</html>
