<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if($_SESSION['is_flag']!=2){
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $id = $_GET['id'];
    //执行sql语句的查询语句
    $sql1 = "select * from books where book_id=$id";
    $result = mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<html>
    <head>
        <title>图书详情信息</title>
		<style>
		    td{
                height:45px
            }
            textarea{
                font-size: 16px;
            }
            input{
                cursor: pointer;
            }
		</style>
	</head>
	<body style='background: url(../images/bg3.jpg) top center no-repeat; background-size:cover'>
		<h2 align='center' style='margin-top:5%'>图 书 详 情 信 息</h2>
		<form action='books_update.php?id=<?php echo $id;?>' method='post'>
		    <table align='center'>
                <?php
                    while($row = mysqli_fetch_array($result)){
                ?>
		        <tr>
                    <th style='width:120px'>书本名称:</th>
                    <td>
                        <?php
                            echo $row["book_name"];
                        ?>
                    </td>
                </tr>
		        <tr>
                    <th>书本价格:</th>
                    <td>
                    <?php
                        echo $row["price"];
                    ?>元
                    </td>
                </tr>
		        <tr>
                    <th>书本作者:</th>
                    <td>
                    <?php
                        echo $row["author"];
                    ?>
                    </td>
                </tr>
		        <tr>
                    <th>出版社:</th>
                    <td>
                    <?php
                        echo $row["publisher"];
                    ?>
                    </td>
                </tr>
                <tr>
                    <th>图书类别:</th>
                    <td>
                    <?php
                        echo $row["book_type"];
                    ?> 
                    </td>
                </tr>
                <tr>
                    <th>库存:</th>
                    <td>
                    <?php
                        echo $row["number"];
                    ?>本
                    </td>
                </tr>
                <tr style='height:145px'><th>书本介绍:</th>
                    <td>
                        <textarea rows='8' cols='40' style='resize:vertical;letter-spacing:2px;' readonly><?php echo $row["mark"];?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' align='center'>
                        <input type='submit' value='修 改' style='width:80px;height:25px;background-color:lightseagreen'/>
                        <input type='button' value='返 回' onclick='window.location.href="../books/books_list.php"' style='width:80px;height:25px;background-color:lightseagreen'/>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </form>
    </body>
</html>