<?php
session_save_path('../session/');
session_start();
include '../config/conn.php';
if ($_SESSION['is_flag'] != 2) {
    echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
}
// 设置文档类型：，utf-8支持中文文档
header("Content-Type:text/html;charset=utf-8");

//执行sql语句的查询语句
$sql1 = "select * from books";
$result = mysqli_query($db_connect, $sql1);

mysqli_close($db_connect); //关闭数据库资源
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>表格数据</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/layui.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/modules/layer/layer.css">
</head>

<body>

    <table class="layui-hide" id="bookcase" lay-filter="test"></table>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
            <button class="layui-btn layui-btn-sm" lay-event="getData">获取当前页数据</button>
            <button class="layui-btn layui-btn-sm" lay-event="isAll">是否全选</button>
            <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="multi-row">
                多行
            </button>
            <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row">
                单行
            </button>
            <button class="layui-btn layui-btn-sm" id="moreTest">
                更多操作
                <i class="layui-icon layui-icon-down layui-font-12"></i>
            </button>
        </div>
    </script>

    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>

    <script src="../js/layui.simple.js"></script>

    <?php
    class status
    {
        public $code = "";
        public $msg = "";
        public $count = "";
    }
    class booksData
    {
        public $id = "";  //图书编号
        public $name = ""; //图书名称
        public $price = ""; //图书价格
        public $author = ""; //作者
        public $publisher = ""; //出版社
        public $number = "";  //库存
        public $type = "";  //图书类型
        public $mark = "";  //图书介绍
    }
    while ($row = mysqli_fetch_array($result)) {
        //创建状态实例
        $status = new status();
        $status->code = 0;
        $status->msg = "成功";
        $status->count = "100";

        //创建图书实例
        $data = new booksData();
        $data->id = $row["book_id"];
        $data->name = $row["book_name"];
        $data->price = $row["price"];
        $data->author = $row["author"];
        $data->publisher = $row["publisher"];
        $data->number = $row["number"];
        $data->type = $row["book_type"];
        $data->mark = $row["mark"];

        // echo $data->id;
        $sta = json_encode($status, JSON_UNESCAPED_UNICODE);
        $dat = json_encode($data, JSON_UNESCAPED_UNICODE);  //对数组进行json格式化
        // $json_Data = $sta .= $dat;
        // echo $json_Data;
        // var_dump($json_Data);


        //把获取到的数据保存为json文件
        // $jsonFile = fopen("../json/bookListFile".date('y-m-d').".json", "w") or die("打开文件失败！");
        $jsonFile = fopen("../json/bookListFile.json", "w") or die("打开文件失败！");
        fwrite($jsonFile, $json_Data);
        // fclose($jsonFile);
    ?>
        <script>
            layui.use(['table', 'dropdown'], function() {
                var table = layui.table;
                var dropdown = layui.dropdown;

                // 创建渲染实例
                table.render({
                    elem: '#bookcase',
                    url: '../books/test.php', // 此处为静态模拟数据，实际使用时需换成真实接口
                    parseData: function(res) { //res 即为原始返回的数据
                        return {
                            "status": 200, //解析接口状态
                            "msg": "success", //解析提示文本
                            "count": res.count, //解析数据长度
                            "data": res, //解析数据列表
                        }
                    },
                    response: {
                        statusName: 'status', //规定数据状态的字段名称，默认：code
                        statusCode: 200, //规定成功的状态码，默认：0
                        msgName: 'msg', //规定状态信息的字段名称，默认：msg
                        countName: 'count', //规定数据总数的字段名称，默认：count
                        dataName: 'data' //规定数据列表的字段名称，默认：data
                    },
                    toolbar: '#toolbarDemo',
                    defaultToolbar: ['filter', 'exports', 'print', {
                        title: '帮助',
                        layEvent: 'LAYTABLE_TIPS',
                        icon: 'layui-icon-tips'
                    }],
                    height: 'full-200', // 最大高度减去其他容器已占有的高度差
                    cellMinWidth: 100,
                    totalRow: true // 开启合计行
                        ,
                    page: true, //开启分页
                    cols: [
                        [{
                                type: 'checkbox',
                                fixed: 'left'
                            }, {
                                field: 'id',
                                fixed: 'left',
                                width: 120,
                                title: '图书编号',
                                sort: true,
                                align: 'center',
                                totalRowText: '合计：'
                            }, {
                                field: 'name',
                                width: 120,
                                title: '图书名称',
                                align: 'center'
                            }, {
                                field: 'price',
                                title: '价格(单位:元)',
                                hide: 0,
                                width: 150,
                                align: 'center',
                                sort: true
                            }, {
                                field: 'author',
                                width: 100,
                                align: 'center',
                                title: '作者'
                            },
                            {
                                field: 'publisher',
                                width: 120,
                                title: '出版社',
                                align: 'center'
                            }, {
                                field: 'type',
                                width: 100,
                                title: '图书类别',
                                align: 'center'
                            }, {
                                field: 'number',
                                title: '库存',
                                width: 100,
                                sort: true,
                                align: 'center'
                            }, {
                                field: 'mark',
                                width: 120,
                                title: '图书介绍',
                                edit: 'textarea',
                                minWidth: 260,
                                align: 'center',
                                style: '-moz-box-align: start;'
                            }, {
                                fixed: 'right',
                                title: '操作',
                                width: 125,
                                minWidth: 125,
                                align: 'center',
                                toolbar: '#barDemo'
                            }
                        ]
                    ],
                    done: function() {
                        var id = this.id;

                        // 更多操作
                        dropdown.render({
                            elem: '#moreTest' //可绑定在任意元素中，此处以上述按钮为例
                                ,
                            data: [{
                                    id: 'add',
                                    title: '添加'
                                }, {
                                    id: 'update',
                                    title: '编辑'
                                }, {
                                    id: 'delete',
                                    title: '删除'
                                }]
                                //菜单被点击的事件
                                ,
                            click: function(obj) {
                                var checkStatus = table.checkStatus(id)
                                var data = checkStatus.data; // 获取选中的数据
                                switch (obj.id) {
                                    case 'add':
                                        layer.open({
                                            title: '添加',
                                            type: 1,
                                            area: ['80%', '80%'],
                                            content: '<div style="padding: 16px;">自定义表单元素</div>'
                                        });
                                        break;
                                    case 'update':
                                        if (data.length !== 1) return layer.msg('请选择一行');
                                        layer.open({
                                            title: '编辑',
                                            type: 1,
                                            area: ['80%', '80%'],
                                            content: '<div style="padding: 16px;">自定义表单元素</div>'
                                        });
                                        break;
                                    case 'delete':
                                        if (data.length === 0) {
                                            return layer.msg('请选择一行');
                                        }
                                        layer.msg('delete event');
                                        break;
                                }
                            }
                        });
                    },
                    error: function(res, msg) {
                        console.log(res, msg)
                    }
                });

                // 工具栏事件
                table.on('toolbar(test)', function(obj) {
                    var id = obj.config.id;
                    var checkStatus = table.checkStatus(id);
                    var othis = lay(this);
                    switch (obj.event) {
                        case 'getCheckData':
                            var data = checkStatus.data;
                            layer.alert(layui.util.escape(JSON.stringify(data)));
                            break;
                        case 'getData':
                            var getData = table.getData(id);
                            console.log(getData);
                            layer.alert(layui.util.escape(JSON.stringify(getData)));
                            break;
                        case 'isAll':
                            layer.msg(checkStatus.isAll ? '全选' : '未全选')
                            break;
                        case 'multi-row':
                            table.reload('bookcase', {
                                // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
                                lineStyle: 'height: 95px;'
                            });
                            layer.msg('即通过设置 lineStyle 参数可开启多行');
                            break;
                        case 'default-row':
                            table.reload('bookcase', {
                                lineStyle: null // 恢复单行
                            });
                            layer.msg('已设为单行');
                            break;
                        case 'LAYTABLE_TIPS':
                            layer.alert('Table for layui-v' + layui.v);
                            break;
                    };
                });

                //触发单元格工具事件
                table.on('tool(test)', function(obj) { // 双击 toolDouble
                    var data = obj.data;
                    //console.log(obj)
                    if (obj.event === 'del') {
                        layer.confirm('确认删除某本书吗？', function(index) {
                            obj.del();
                            layer.close(index);
                        });
                    } else if (obj.event === 'edit') {
                        layer.open({
                            title: '编辑',
                            type: 1,
                            area: ['80%', '80%'],
                            content: '<div style="padding: 16px;">自定义表单元素</div>'
                        });
                    }
                });

                //触发表格复选框选择
                table.on('checkbox(test)', function(obj) {
                    console.log(obj)
                });

                //触发表格单选框选择
                table.on('radio(test)', function(obj) {
                    console.log(obj)
                });

                // 行单击事件
                table.on('row(test)', function(obj) {
                    //console.log(obj);
                    //layer.closeAll('tips');
                });
                // 行双击事件
                table.on('rowDouble(test)', function(obj) {
                    console.log(obj);
                });

                // 单元格编辑事件
                table.on('edit(test)', function(obj) {
                    var field = obj.field //得到字段
                        ,
                        value = obj.value //得到修改后的值
                        ,
                        data = obj.data; //得到所在行所有键值

                    var update = {};
                    update[field] = value;
                    obj.update(update);
                });
            });
        </script>
    <?php } ?>

</body>

</html>