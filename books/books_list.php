<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if($_SESSION['is_flag']!=2){
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    
    //执行sql语句的查询语句
    $sql1 = "select * from books";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<html>
    <head>
        <title>图书列表</title>
        <link rel="stylesheet" href="../css/layui.css">
        <script src="../js/jquery-3.3.1.min.js"></script>
        <style>
            *{
                margin: 0;padding:0;
            }
            .top{
                height: 30px;
                width: 100%;
                background: #666;
                line-height: 30px;
                text-align: right;
            }
            .tab {
                width: 85%;
                margin: 2.2% auto;
                text-align: center;
            }
            .tab tr,th,td{
                border: 1px solid black;
            }
            .btn{
				width: 90px;
				height: 28px;
				background-color: lightseagreen;
				border-radius: 5px;
				cursor: pointer;
				color: white;
				font-size: 16px;
				border: none;
			}
            .btn1{
				width: 90px;
				height: 28px;
				background-color: lightseagreen;
				border-radius: 5px;
				cursor: pointer;
				color: white;
				font-size: 16px;
				border: none;
                margin-top: 7px;
			}
            .back {
                width: 50px;
                height: 50px;
                position: fixed;
                z-index: 99;
                bottom: 30px;
                right: 5px;
                cursor: pointer;
                display: none;
            }
        </style>
         
    </head>
    <body>
        <div class='top'>
            <a href='#' onclick='window.location.href="../administrator/index.php"' style="text-decoration:none;">
                <font size='3' color='white'>返回首页&nbsp;&nbsp;&nbsp;</font>
            </a>
        </div>
        <table class="tab" cellspacing='0' cellpadding="3">
            <tr height="50px">
                <th colspan="8"><h2>馆藏图书列表</h2></th>
                <td>
                    <a href='../books/add_books.php'>
                        <input type="button" name="add" value="添加图书" class="btn"/>
                    </a>
                </td>
            </tr>
            <tr style='background-color:lightseagreen;height:45px'>
                <th>图书编号</th>
                <th>图书名称</th>
                <th>价格(单位:元)</th>
                <th>作者</th>
                <th>出版社</th>
                <th>图书类别</th>
                <th>库存(单位:本)</th>
                <th>介绍</th>
                <th>操作</th>
            </tr>

            <?php
                while($row = mysqli_fetch_array($result)){
            ?>
            <tr>
                <td>
                    <?php
                        echo $row["book_id"];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row["book_name"];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row["price"];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row["author"];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row["publisher"];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row["book_type"];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row["number"];
                    ?>
                </td>
                <td width="27%">
                    <?php
                        echo $row["mark"];
                    ?>
                </td>
                <td height="90px" width="9%">
                    <a href='../books/books_detail.php?id=<?php echo $row["book_id"];?>'>
                        <input type="button" value="查看" class="btn"/>
                    </a>
                    <a href='javascript:;' class="delbtn">
                        <input type="button" data-type="tip" id="del" value="删除" class="btn1"/>
                    </a>
                    <script src="https://www.layuicdn.com/layui/layui.js"></script>
                    <script type="text/javascript">
                        layui.use(['layer'],function(){
                            var layer = layui.layer;

                            $('.delbtn #del').click(function(){
                                // layer.msg("hello!");  //测试
                                layer.confirm('您是否确认删除此书？', {
                                    title: '温馨提示',
                                    id: 'conDel',  //解决重复弹窗
                                    btn: ['确认','取消'] //按钮
                                }, function(){
                                    layer.msg('已删除', {icon: 1});
                                    location.href="../books/books_delete.php?id=<?php echo $row["book_id"];?>";
                                }, function(){
                                    layer.msg('取消操作', {
                                    time: 1500, //1.5s后自动关闭
                                    });
                                });
                            });
                        })
                        // layui.use(function(){
                        //     var layer = layui.layer;
                        //     <!-- layer.alert('hello'); -->
                        //     //触发事件
                        //     var active = {
                        //         tip: function(){
                        //             layer.confirm('确认删除吗？', {
                        //                 btn: ['确认','取消'] //按钮
                        //             }, function(){
                        //                 layer.msg('已删除', {icon: 1});
                        //                 location.href="../books/books_delete.php?id=<?php echo $row["book_id"];?>";
                        //             }, function(){
                        //                 layer.msg('取消操作', {
                        //                 time: 5000, //20s后自动关闭
                        //                 });
                        //             });
                        //         }
                        //     }
                        //     $('#del').click(function(){
                        //         var type = $(this).data('type');
                        //         active[type] ? active[type].call(this) : '';
                        //     });
                        // });
                    </script>
                </td>
            </tr>
            <?php
                }
            ?>
		</table>
        <img id="gotoTop" title="返回顶部" class="back" src="../images/gotop.png" />
        
        <script type="text/javascript">
			function gotoTop(minHeight){
			    // 定义点击返回顶部图标后向上滚动的动画
			    $("#gotoTop").click(
			        function(){$('html,body').animate({scrollTop:'0px'},'slow');
			    })
			    // 获取页面的最小高度
			    minHeight? minHeight = minHeight:minHeight = 100;
			    // 为窗口的scroll事件绑定处理函数
			    $(window).scroll(function(){
			        // 获取窗口的滚动条的垂直滚动距离
			        var s = $(window).scrollTop();
                    // 当窗口的滚动条的垂直距离大于页面的最小高度时，让返回顶部图标渐现，否则渐隐
			        if( s > minHeight){
			            $("#gotoTop").fadeIn(500);
			        }else{
			            $("#gotoTop").fadeOut(500);
			        };
			    });
			};
			gotoTop();
		</script>
    </body>
</html>