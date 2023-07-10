<?php
    /*
     * 图书列表信息综合模块
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../oauth/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $usertype = $_SESSION['usertype'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>图书数据中心</title>
    <link rel="shortcut icon" href="../../skin/images/favicon.png" />
    <meta name="renderer" content="webkit">
    <meta name="applicable-device" content="pc,mobile">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../../skin/css/layui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../skin/css/modules/layer/layer.css">
    <style>
        .have{
            color: #009688;
        }
        .use{
            color: #ff5722;
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
            // return false
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
            <table class="layui-hide" id="bookcase" lay-filter="test"></table>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <?php
                        if($item['book_manager'] == 1) {
                            echo "<button class='layui-btn layui-btn-sm' lay-event='addBook'><i class='layui-icon layui-icon-add-1'></i>新增图书</button>";
                            echo "<button class='layui-btn layui-btn-sm' lay-event='importBooks'><i class='layui-icon layui-icon-add-1'></i>批量导入</button>";
                            echo "<button class='layui-btn layui-btn-sm layui-btn-danger' lay-event='delBooks'><i class='layui-icon layui-icon-delete'></i>批量删除</button>";
                        }else{
                            echo "<button class='layui-btn layui-btn-sm layui-btn-primary' lay-event='sunshine' id='sunshine'><i class='layui-icon layui-icon-diamond'></i></button>";
                        }
                    ?>
                    <button class='layui-btn layui-btn-sm layui-btn-primary' lay-event='multi-row'>多行显示</button>
                    <button class='layui-btn layui-btn-sm layui-btn-primary' lay-event='default-row'>单行显示</button>
                    <button class='layui-btn layui-btn-sm' lay-event='tip' id="tip">tips</button>
                </div>
            </script>

            <script type="text/html" id="barDemo">
                <?php
                    if($item['book_manager'] == 1) {
                        echo "<a class='layui-btn layui-btn-xs' lay-event='detail'>查看</a>";
                        echo "<a class='layui-btn layui-btn-xs' lay-event='edit'>编辑</a>";
                        echo "<a class='layui-btn layui-btn-xs layui-btn-danger' lay-event='del'>删除</a>";
                    }else{
                        echo "<a class='layui-btn layui-btn-sm' lay-event='detail'>查看</a>";
                    }
                ?>
            </script>
            <script type="text/html" id="book_name">
                <p style="color: #333;font-weight: 400;">{{d.book_name}}</p>
                <!--<p style="font-weight: bold;">《{{d.book_name}}》</p>  可以在模板中手动添加书名号-->
            </script>
            <script type="text/html" id="img"> <img src="{{d.book_cover}}" width="30" height="32" alt=""> </script>
            <script type="text/html" id="status">
                <p class="{{d.status == 0 ? 'have' : 'use'}}">{{d.status == 0 ? '在库' : '已借出'}}</p>
            </script>
            <div id="laypage"></div>
            <div id="test">
                <script>

                </script>
            </div>
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
    <script src="../../skin/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        let usertype = '<?php echo $usertype ?>'; //用户身份
        layui.config({
            version: '1314920'   //更新js缓存
        })

        layui.use(['table','laypage'], function() {
            let table = layui.table
                ,laypage = layui.laypage
                ,pageNo = 1  //当前页码
                ,pageSize = 15;  //每页条数

            // 创建渲染实例
            table.render({
                elem: '#bookcase',
                type: 'POST',
                url: '../../controllers/books_center/book_listData',
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
                height: 'full-160', // 最大高度减去其他容器已占有的高度差
                cellMinWidth: 100,
                // totalRow: true, // 开启合计行
                page: false, //开启分页
                even: true, //隔行换色
                title: '图书清单表', //表格名称
                loading: true,
                text: {
                    none: '暂无数据'
                },
                cols: [
                    [{
                        type: 'checkbox',
                        fixed: 'left'
                    }, {
                        field: 'book_id',
                        fixed: 'left',
                        width: 105,
                        title: '图书编号',
                        sort: true,
                        hide: false,  //隐藏
                        align: 'center'
                    },{
                        field: 'ISBN',
                        width: 180,
                        title: 'ISBN',
                        sort: true,
                        align: 'center'
                    },{
                        field: 'book_name',
                        width: 300,
                        title: '图书名称',
                        align: 'center',
                        templet: '#book_name'
                    }, {
                        field: 'author',
                        width: 140,
                        align: 'center',
                        title: '作者'
                    }, {
                        field: 'book_type',
                        width: 150,
                        title: '图书类别',
                        align: 'center'
                    }, {
                        field: 'publisher',
                        width: 150,
                        title: '出版社',
                        align: 'center'
                    }, {
                        field: 'price',
                        title: '价格(元)',
                        width: 90,
                        align: 'center',
                        sort: true
                    }, {
                        field: 'number',
                        title: '库存(本)',
                        width: 90,
                        align: 'center',
                        sort: true
                    }, {
                        field: 'book_cover',
                        title: '图书封面',
                        width: 100,
                        align: 'center',
                        templet: '#img'
                    }, {
                        field: 'mark',
                        width: 170,
                        title: '图书简介（可编辑）',
                        edit: 'text', //后续修改单独更新值到数据库中update book_list set mark='修改后的值' where id=''
                        minWidth: 320,
                        align: 'left',
                        style: '-moz-box-align: start;'
                    }, {
                        field: 'save_position',
                        width: 190,
                        title: '藏书位置',
                        align: 'center',
                        style: '-moz-box-align: start;'
                    }, {
                        field: 'status',  //借阅状态判断 0 在库 1 借出
                        width: 120,
                        title: '图书状态',
                        align: 'center',
                        style: '-moz-box-align: start;',
                        templet: '#status'
                    }, {
                        field: 'borrow_num',
                        width: 120,
                        title: '借阅次数',
                        align: 'center',
                        sort: true,
                        style: '-moz-box-align: start;'
                    }, {
                        field: 'create_date',
                        width: 175,
                        title: '入库时间',
                        align: 'center',
                        style: '-moz-box-align: start;'
                    }, {
                        field: 'update_date',
                        width: 175,
                        title: '更新时间',
                        align: 'center',
                        style: '-moz-box-align: start;'
                    }, {
                        fixed: 'right',
                        title: '操作',
                        width: 165,
                        // minWidth: 120,
                        align: 'center',
                        toolbar: '#barDemo'
                    }]
                ],
                // initSort:{   //按编号升序排序
                //     field: 'book_id',
                //     type: 'asc',
                // },
                done: function (res, curr, count){
                    hoverOpenImg();//显示大图
                    // console.log(res);
                    //在获取到表格数据后加载分页组件，点击分页时调用table的reload方法重新加载表格数据达到分页效果
                    laypage.render({
                        elem: 'laypage', //分页容器ID
                        count: res.count, //通过后台拿到总页数
                        curr: pageNo, //当前页码
                        limit: pageSize, //分页大小
                        limits: [15,20,30,50],
                        groups: 3,  //连续出现的页码数
                        layout: ['prev', 'page', 'next', 'skip', 'count', 'limit'],
                        jump: function (obj, first) {  //跳转方法
                            // console.log(obj);
                            if (!first) {  //若不为第一页
                                pageNo = obj.curr;  //设置全局变量page 为当前选择页码
                                pageSize = obj.limit;  //设置全局变量limit 为当前选择分页大小
                                table.reload('bookcase', { //重新加载表格
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
            table.on('toolbar(test)', function(obj) {
                let id = obj.config.id;
                let checkStatus = table.checkStatus(id);
                // 获取选中的数据
                let data = checkStatus.data;
                let arr_id = [];  //选中的图书id
                let arr_status = [] //选中的图书对应的借阅状态
                let num = data.length; //选中的数量
                //把选中的图书id添加在一个数组中
                data.map(function (item){
                    arr_id.push(item.book_id);
                    arr_status.push(item.status);
                })
                //两个数组拼成对象
                let dataArr = arr_id.map((book_id, i) => ({book_id, status: arr_status[i]}));
                // console.log(dataArr); //打印选中的图书id数组
                // console.log(arr_status);
                switch (obj.event) {
                    case 'delBooks':
                        if(data.length === 0){
                            layer.msg('请至少选择一项~',{
                                time: 1500
                            });
                        }else {
                            layer.confirm('是否确认删除这 ' + num + ' 本图书？',{title: '温馨提示'}, function (index) {
                                $.ajax({
                                    url: '../../controllers/books_center/delete_books',
                                    type: 'POST',
                                    data: JSON.stringify(dataArr),
                                    dataType: 'json',
                                    success: function (res){
                                        // console.log(res);
                                        if(res.code === 200){
                                            layer.msg(res.msg, {
                                                // icon: 1,
                                                time: 1500
                                            },function (){
                                                if(pageSize - num === 0){
                                                    let current = 1;
                                                }else {
                                                    current = 0;
                                                }
                                                table.reload('bookcase',{
                                                    url: '../../controllers/books_center/book_listData',
                                                    where: {   //接口参数，page为分页参数
                                                        page: pageNo-current, //删除整页的时候页面-1
                                                        limit: pageSize
                                                    }
                                                },true) //表格数据重载
                                            })
                                        }else{
                                            layer.msg(res.msg, {
                                                icon: 7,
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
                    case 'addBook':
                        layer.open({
                            title: '<i class="layui-icon layui-icon-add-1"></i>新增图书',
                            type: 2,
                            area: ['50%', '90%'],
                            skin: 'layui-layer-molv',
                            maxmin: true,
                            // shadeClose: true, //点击遮罩关闭=窗口
                            content: '../books_center/add_book'
                        })
                        break;
                    case 'importBooks':
                        layer.open({
                            title: '<i class="layui-icon layui-icon-add-1"></i>批量导入图书',
                            type: 2,
                            area: ['48%', '85%'],
                            skin: 'layui-layer-molv',
                            move: false,
                            content: '../../classes/import_data?import_type=0' //type 0 图书
                        })
                        break;
                    case 'multi-row':
                        table.reload('bookcase', {
                            // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
                            lineStyle: 'height: 100px;'
                        });
                        layer.msg('显示更多内容！');
                        break;
                    case 'default-row':
                        table.reload('bookcase', {
                            lineStyle: null // 恢复单行
                        });
                        layer.msg('显示更少内容！');
                        break;
                    case 'tip':
                        layer.tips('尝试左右滑动表格查看~', '#tip',{
                            tips: [2,'#666'],
                            time: 1500
                        });
                        break;
                    case 'sunshine':
                        layer.tips('力学如力耕，勤惰尔自知。便使书种多，会有岁稔时。', '#sunshine',{
                            tips: [3,'#666'],
                            time: 1500
                        });
                        break;
                }
            })

            //触发单元格工具事件
            table.on('tool(test)', function(obj) { // 双击 toolDouble
                let data = obj.data;
                // console.log(data);
                let id = data.book_id;
                // 图书详情url
                let url = '../books_center/book_detail?id='+id;
                // 图书更新信息url
                let url1 = '../books_center/update_book?id='+id;
                // alert(url);
                // console.log(obj);
                if (obj.event === 'detail') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-search"></i> 图书详情',
                        type: 2,
                        area: ['45%', '88%'],
                        content: url,
                        skin: 'layui-layer-molv',
                        maxmin: true,
                        shadeClose: true,
                        scrollbar: false  //弹窗锁定滚动条
                    });
                } else if (obj.event === 'edit') {
                    layer.open({
                        title: '<i class="layui-icon layui-icon-edit"></i> 编辑图书信息',
                        type: 2,
                        area: ['45%', '88%'],
                        content: url1,
                        // btn: ['确认','取消'],
                        skin: 'layui-layer-molv',
                        maxmin: true,
                        // shadeClose: true,
                        success: function (){
                            // layer.close();
                        }
                    })
                }else if(obj.event === 'del'){
                    let bookName = obj.data.book_name; //获取选中的图书名称
                    layer.confirm('确认删除图书《' + bookName + '》吗？',{title: '温馨提示'}, function (index) {
                        $.ajax({
                            url: '../../controllers/books_center/delete_book',
                            type: 'POST',
                            data: id,
                            dataType: 'json',
                            success: function (res){
                                // console.log(res);
                                if(res.code === 200){
                                    layer.msg(res.msg, {
                                        // icon: 1,
                                        time: 1500
                                    },function (){
                                        table.reload('bookcase',{},true); //表格数据重载
                                    })
                                }else{
                                    layer.msg(res.msg, {
                                        icon: 7,
                                        time: 1500
                                    })
                                }
                            }
                        })
                        layer.close(index); //点击确认后关闭窗口
                    }, function () {
                        // layer.msg('取消操作', {
                        //     // icon: 7,
                        //     time: 1500, //1.5s后自动关闭
                        // })
                    })
                }
            })

            //触发表格复选框选择
            table.on('checkbox(test)', function(obj) {
                // console.log(obj);
            });

            //触发表格单选框选择
            table.on('radio(test)', function(obj) {
                // console.log(obj)
            });

            // 行单击事件
            table.on('row(test)', function(obj) {
                //console.log(obj);
                //layer.closeAll('tips');
            });
            // 行双击事件
            table.on('rowDouble(test)', function(obj) {
                // console.log(obj);
            });

            // 单元格编辑事件
            table.on('edit(test)', function(obj) {
                // console.log(obj);
                let field = obj.field, //得到字段
                    value = obj.value, //得到修改后的值
                    data = obj.data; //得到所在行所有键值

                $.ajax({
                    type: "POST",
                    url: '../../controllers/books_center/editUnit',
                    data: {
                        'id': data.book_id,
                        'mark': value,
                        'type': 0  //图书列表单元格
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
                                shade: .2,
                                time: 1000
                            },function (){
                                table.reload('bookcase');
                            })
                        }
                    }
                })
            })
        })

        //大图显示封面
        function hoverOpenImg(){
            let img_show = '暂无封面'; // tips提示
            $('td img').hover(function(){
                //alert($(this).attr('src'));
                let img = "<img src='"+$(this).attr('src')+"' style='width:130px;' />";
                img_show = layer.tips(img, this,{
                    tips:[2, 'rgba(41,41,41,.3)']
                    ,area: ['160px']
                });
            },function(){
                layer.close(img_show);
            });
            $('td img').attr('style','max-width: 130px');
        }
    </script>
</body>

</html>