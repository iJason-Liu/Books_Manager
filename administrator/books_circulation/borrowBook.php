<?php
    /*
     * 图书借阅板块，提供搜索，快速续借与归还
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
    <title>借阅中心</title>
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

        .info-input{
            height: 35px;
            line-height: 1.3;
            line-height: 35px \9;
            border-width: 1px;
            border-style: solid;
            background-color: #fff;
            color: rgba(0, 0, 0, .85);
            border-radius: 2px;
            border-color: #eee;
            padding-left: 10px;
            transition: all .3s;
            -webkit-transition: all .3s;
        }
        .info-input:hover{
            border: 1px solid #429488;
        }

        .layui-select-title input{
            text-align: center;
            padding-left: 0;
            height: 45px;
        }

        #search{
            height: 43px;
            margin-left: -10px;
            border-radius: 0 2px 2px 0;
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
    </style>
    <script type="text/javascript">
        //禁用复制
        document.oncopy = function () {
            // return false;
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
                <li class="layui-nav-item layui-hide-xs"><a href="../../upload/pdf/小新图书馆操作指南.pdf" target="_blank">操作指南</a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <!-- 右侧消息 -->
                <li class="layui-nav-item" lay-header-event="msg" lay-unselect>
                    <a href="javascript:;">
                        <!--<i class="layui-icon layui-icon-notice layui-font-18"></i><span class="layui-badge layui-badge-dot"></span>-->
                        通知消息<span class="layui-badge layui-hide"></span>
                    </a>
                </li>
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
            <fieldset class="layui-elem-field layui-field-title" style="border: 1px solid #C9C9C9;margin: 15px 20px 0 20px;padding: 15px;">
                <legend>读者基础信息</legend>
                <?php
                    while ($item = mysqli_fetch_array($info_res)){
                        $card_status = $item['card_status'];  //借阅卡状态
                        $borrow_num = $item['borrow_limit'];  //借书数量
                ?>
                <div class="layui-row layui-col-space15">
                    <div class="layui-col-md3 layui-col-sm4">
                        <label><span style="color: #ff0000;">*</span>借阅卡号：</label>
                        <input disabled type='text' placeholder='读者借阅卡号' value='<?php echo $item['cardNo']=='' ? $item['id'] : $item['cardNo'] ?>' class='info-input'>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4">
                        <label><span style="color: #ff0000;">*</span>姓名：</label><input disabled type="text" placeholder="读者姓名" value="<?php if($usertype == '超级管理员') echo $item['username'];else echo $item['name'] ?>" class="info-input">
                    </div>
                    <div class="layui-col-md3 layui-col-sm4">
                        <label>性别：</label><input disabled type="text" value="<?php echo $item['sex'] ?>" class="info-input">
                    </div>
                    <div class="layui-col-md3 layui-col-sm4">
                      <label>联系电话：</label><input disabled type="text" placeholder="联系电话" value="<?php echo $item['mobile'] ?>" class="info-input">
                    </div>
                    <div class="layui-col-md3 layui-col-sm4">
                      <label><span style="color: #ff0000;">*</span>借阅卡状态：</label>
                        <?php
                            if($card_status == 0){
                                echo "<input disabled type='text' style='color: #429488;' placeholder='借阅卡状态' value='正常' class='info-input'>";
                            }else{
                                echo "<input disabled type='text' style='color: #ff0000;' placeholder='借阅卡状态' value='异常' class='info-input'>";
                            }
                        ?>
                    </div>
                    <div class="layui-col-md3 layui-col-sm4">
                      <label>读者类型：</label><input disabled type="text" placeholder="读者类型" value="<?php echo $item['user_type'] ?>" class="info-input">
                    </div>
                    <div class="layui-col-md3 layui-col-sm4">
                      <label><span style="color: #ff0000;">*</span>可借数量：</label><input disabled type="number" placeholder="借书数量" value="<?php echo $borrow_num ?>" class="info-input">
                    </div>
                </div>
                <?php
                    }
                ?>
            </fieldset>

            <!--搜索-->
            <div class="layui-form" lay-filter="form_data" style="margin: 20px 20px 0 20px;display: flex;text-align: center">
                <div class="layui-form-item" style="width: 120px;">
                    <div class="layui-input-inline" style="width: 120px;">
                        <select name="keywords_type"  lay-filter="keys">
                            <option value="0">书名</option>
                            <option value="1">ISBN</option>
                            <option value="2">图书编号</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-inline" style="width: 520px;margin-right: 10px;">
                        <input style="height: 45px;" type="text" name="keywords" id="key" autocomplete="off" placeholder="请输入关键词搜索图书完成借阅" class="layui-input">
                    </div>
                    <button class="layui-btn" id="search"><i class='layui-icon layui-icon-search'></i> 搜索</button>
                </div>
            </div>

            <!--显示借阅情况列表-->
            <table class="layui-hide" id="dataList" lay-filter="tab"></table>
            <script type="text/html" id="barDemo">
                <a class='layui-btn layui-btn-xs' lay-event='renew'>续借</a>
                <a class='layui-btn layui-btn-danger layui-btn-xs' lay-event='return'>归还</a>
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
            <div class="statusBar">当前已借图书数量：<span class="num"></span> 本</div>
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
        layui.use(['table', 'form', 'util'], function() {
            let $ = layui.jquery
                ,layer = layui.layer
                ,table = layui.table
                ,form = layui.form
                ,util = layui.util;

            let card_status = <?php echo $card_status;?>; //用户借阅卡状态
            let current_num = 0;  //当前借书数量

            // 创建渲染实例
            table.render({
                elem: '#dataList',
                type: 'POST',
                url: '../../controllers/books_circulation/borrow_listData',
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
                height: 'full-389', // 最大高度减去其他容器已占有的高度差
                cellMinWidth: 100,
                page: false, //开启分页
                even: true, //隔行换色
                loading: true,
                text: {
                    none: '您还没有借过图书呢~'
                },
                cols: [
                    [{
                        field: 'book_id',
                        fixed: 'left',
                        width: 130,
                        title: '图书编号',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'book_name',
                        width: 360,
                        title: '图书名称',
                        align: 'center'
                    }, {
                        field: 'book_price',
                        title: '价格（元）',
                        width: 110,
                        align: 'center'
                    }, {
                        field: 'borrow_limitDay',
                        width: 110,
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
                        field: 'borrow_date',
                        width: 160,
                        title: '借书日期',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'back_date',
                        width: 160,
                        title: '应还日期',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'renew_backDate',
                        width: 160,
                        title: '续借后应还日期',
                        sort: true,
                        align: 'center'
                    }, {
                        field: 'mark',
                        minwidth: 120,
                        title: '备注',
                        align: 'center'
                    }, {
                        fixed: 'right',
                        title: '操作',
                        width: 120,
                        align: 'center',
                        toolbar: '#barDemo'
                    }]
                ],
                initSort: {  //排序，已归还始终在未归还后面
                    field: 'is_back', //排序字段，对应 cols 设定的各字段名
                    type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                },
                done: function (res, curr, count){
                    // console.log(res);
                    current_num = res.count;
                    $('.num').text(res.count);  //已借数量（状态为未归还）
                },
                error: function(res, msg) {
                    console.log(res, msg)
                }
            });

            //触发单元格工具事件
            table.on('tool(tab)', function(obj) {
                let data = obj.data;
                // console.log(data);
                let book_id = data.book_id;
                let is_back = data.is_back; //图书状态 是否归还
                let url = '../books_circulation/fast_renew?book_id='+book_id;
                // console.log(obj);
                if (obj.event === 'renew') {
                    if(is_back == 1){
                        layer.msg('该图书已经归还，如有需要，请重新借阅！', {
                            time: 2500,
                            // anim: 6,
                            shade: .2,
                            icon: 7
                        })
                    }else if(card_status == 1){
                        layer.msg('您的借阅卡状态异常，无法完成续借！', {
                            time: 2500,
                            icon: 5,
                            shade: .2,
                        })
                    }else{
                        layer.open({
                            title: '<i class="layui-icon layui-icon-note"></i> 快速续借',
                            type: 2,
                            area: ['540px', '480px'],
                            skin: 'layui-layer-molv',
                            scrollbar: false,
                            move: false,
                            content: url,
                            success: function (){
                                // layer.close();
                            }
                        })
                    }
                }else if(obj.event === 'return'){
                    if(is_back == 1){
                        layer.msg('该图书已经归还，无需重复操作！', {
                            icon: 7,
                            // anim: 6,
                            shade: .2,
                            time: 2500
                        })
                    }else {
                        layer.confirm('是否确认归还图书《'+data.book_name+'》？',{title: '温馨提示',icon :7}, function (index) {
                            $.ajax({
                                url: '../../controllers/books_circulation/return_book',
                                type: 'POST',
                                data: JSON.stringify(data),
                                dataType: 'json',
                                success: function (res) {
                                    // console.log(res);
                                    if (res.code === 200) {
                                        layer.msg(res.msg, {
                                            icon: 6,
                                            shade: .2,
                                            time: 2000
                                        }, function () {
                                            table.reload('dataList', {}, true) //表格数据重载
                                        })
                                    } else {
                                        layer.msg(res.msg, {
                                            icon: 7,
                                            anim: 6,
                                            shade: .2,
                                            time: 2000
                                        })
                                    }
                                }
                            })
                            layer.close(index); //点击确认后关闭窗口
                        })
                    }
                }
            })

            //对借阅卡状态异常进行拒绝，提示
            $(function (){
                if(card_status === 1){
                    layer.alert('您的借阅卡状态异常，请前往通知消息查看详情或联系管理员处理！', {
                        title: '系统提示',
                        btn: ['我知道了'],
                        icon: 7
                    })
                }
            })

            // 搜索
            function search(){
                let data = form.val('form_data');
                // console.log(data);
                let keywords = $.trim(data.keywords);
                let keywords_type = data.keywords_type;
                let borrow_num = <?php echo $borrow_num;?>;  //借阅数量
                let url = '../books_circulation/search_book?keywords='+keywords+'&keywords_type='+keywords_type;
                if(keywords === ''){
                    layer.msg('请输入搜索关键词', {
                        time: 2000
                    })
                    $('#key').focus();
                }else if(card_status === 1){
                    layer.msg('您的借阅卡状态异常，请前往通知消息查看详情或联系管理员查看！', {
                        time: 3000,
                        anim: 6,
                        shade: .2,
                        icon: 5
                    }, function (){
                        $('#key').val('');
                    })
                }else if((borrow_num - current_num) <= 0){  //总借书数量 - 当前借书数量
                    layer.msg('您的借书数量已达上限，请归还图书或向管理员申请后再进行操作！', {
                        time: 3000,
                        anim: 6,
                        shade: .2,
                        icon: 5
                    }, function (){
                        $('#key').val(''); //清空输入框
                    })
                }else{
                    let index = layer.open({
                        title: '<i class="layui-icon layui-icon-search"></i> 图书搜索结果（借阅）',
                        type: 2,
                        area: ['48%', '88%'],
                        skin: 'layui-layer-molv',
                        maxmin: true,
                        content: url,
                        success: function (){
                            // layer.close();
                        }
                    })
                    layer.full(index);  //打开即全屏
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
            })

            let state;
            let msg = '';  //消息列表html元素
            let user_id = <?php echo $_SESSION['user_id']; ?>;

            //页面加载时加载消息列表
            $(function (){
                getMsg();
            })

            //获取消息列表
            function getMsg(){
                $.ajax({
                    type: "POST",
                    url: '../../controllers/system/getMsg',
                    data: {
                        user_id: user_id
                    },
                    dataType: 'json',
                    success: function (res) {
                        // console.log(res);
                        state = res.state;  //未读消息的条数
                        let data = res.data;
                        $('.layui-badge').text(res.count); //动态获取消息数量
                        msg = '';
                        if(data.length === 0){
                            msg += "<div style='margin: 50px auto;text-align: center;color: #999;'><img src='../../skin/images/no_msg.png' style='width: 180px;height: 150px;'><p>暂无消息</p></div>";
                        }else {
                            for (let i in data) {
                                let color = data[i].state === '0' ? '#333' : '#999';  //定义已读未读的状态颜色
                                msg += "<div class='msg' style='padding: 15px;border-bottom: 1px solid #ddd;cursor: pointer;'>" +
                                        // "<div>"+data[i].sender+"</div>" +
                                        "<div style='color: " + color + ";font-weight: 500;font-size: 15px;'>" + data[i].content + "</div>" +
                                        "<div style='margin-top: 15px;'>" +
                                        "<span style='color: #777;font-size: 12px;padding: 5px;background: #f3f4f7;border-radius: 4px;'>" + data[i].sender + "</span>" +
                                        "<span style='color: #999;position: absolute;right: 15px;'>" + data[i].createtime + "</span></div>" +
                                        "</div>";
                            }
                        }
                        //有未读消息时显示
                        if(state !== 0){
                            $('.layui-badge').removeClass('layui-hide');
                        }
                    }
                })
            }

            //头部事件
            util.event('lay-header-event', {
                //右侧消息事件
                msg: function () {
                    let index = layer.open({
                        title: "<i class='layui-icon layui-icon-notice'></i> 通知消息 <span style='font-size: 12px;margin-left: 10px;color: #999;cursor:pointer;' title='删除所有消息' class='clearMsg'>清空消息</span>",
                        type: 1,
                        area: ['28%', '92.7%'],
                        offset: ['7.3%', '72%'], //自定义右上角
                        // offset: 'rt', //右上角
                        // anim: 5,
                        shade: .1,  //.1
                        // shadeClose: true,
                        // closeBtn: 2,
                        move: false,  //禁止拖动
                        scrollbar: false, //禁用滚动条
                        content: msg,
                        success: function () {

                        },
                        end: function () {
                            //把消息全部设置成已读，上传ajax设置
                            $.ajax({
                                type: "POST",
                                url: '../../controllers/system/setMsgState',
                                data: {
                                    user_id: user_id,
                                    // msg_id: 1   //单条消息id
                                },
                                dataType: 'json',
                                success: function (res) {
                                    // console.log('消息全部已读');
                                }
                            })
                            //关闭窗口已读消息，再次添加隐藏样式
                            $('.layui-badge').addClass('layui-hide');
                            getMsg();  //重新获取消息列表
                            // if (state !== 0) {  //不等于0时刷新也就是第一次打开时关闭刷新，以后无新消息不刷新
                                // location.reload();
                            // }
                        }
                    })
                    //鼠标移上变色
                    $('.layui-layer-content .msg').mouseover(function () {
                        $(this).css('background-color', '#eaeaee');
                    }).mouseout(function () {
                        $(this).css('background-color', '#fff');
                    })

                    //清空所有消息
                    $('.clearMsg').on('click', function () {
                        layer.confirm('确认删除所有消息吗？',{title: '温馨提示'}, function (index) {
                            $.ajax({
                                type: "POST",
                                url: '../../controllers/system/clearMsg',
                                data: {
                                    user_id: user_id
                                },
                                success: function (res) {
                                    layer.msg('消息已清空！', {
                                        time: 2000
                                    }, function () {
                                        getMsg();
                                    })
                                    layer.close(index); //关闭窗口
                                }
                            })
                            layer.closeAll();
                        }, function (){
                            layer.close(index); //关闭窗口
                        })
                    })
                }
            })
        })
    </script>
</body>
</html>
