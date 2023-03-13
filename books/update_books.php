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
    $sql1 = "select * from book_list where book_id=$id";
    $result = mysqli_query($db_connect,$sql1);

	// 查询图书类别语句
	$sql2="select * from book_type";
    $result1=mysqli_query($db_connect,$sql2);

    mysqli_close($db_connect); //关闭数据库资源
?>
<html>
	<head>
		<title>更新图书信息</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <link href="../css/layui.css" rel="stylesheet">
		<style>
			td {
				height: 60px;
			}
            .tab{
                margin: 20px auto;
            }
            input{
                width: 350px;
                height: 35px;
                padding: 4px;
            }
            textarea{
                font-size: 16px;
                padding: 4px;
                text-overflow: ellipsis;
            }
			.sel{
				width: 137px;
				height: 27px;
				cursor: pointer;
				margin-left: 2px;
			}
		</style>
	</head>
	<body style='background: url(../images/bg3.jpg) top center no-repeat; background-size:cover'>
		<h1 align='center' style='margin-top:10px'>更新图书信息</h1>
        <hr>
		<form action='../books/update_books_check.php?id=<?php echo $id;?>' method='post'>
            <?php
                while($row = mysqli_fetch_array($result)){
					$type = $row['book_type'];
            ?>
			<table class="tab">
				<tr>
					<th style='width:120px'>书本名称:</th>
					<td><input name='name' value='<?php echo $row["book_name"];?>'  /></td>
				</tr>
				<tr>
					<th>书本价格:</th>
					<td><input name='price' type="number" value='<?php echo $row["price"];?>'  /></td>
				</tr>
				<tr>
					<th>书本作者:</th>
					<td><input name='author' value='<?php echo $row["author"];?>'  /></td>
				</tr>
				<tr>
					<th>出 版 社:</th>
					<td><input name='publisher' value='<?php echo $row["publisher"];?>'  /></td>
				</tr>
				<tr>
					<th>图书类别:</th>
					<td>
						<select class="sel" name="bookstype" size="1">
							<option value="<?php echo $type ?>"><?php echo $type ?></option>
                            <?php
                                while($rows=mysqli_fetch_array($result1)){
									// 判断类别表中分类名不等于当前图书分类名时才输出，去除重复
									if($rows['type_name'] != $type){
                            ?>
                            <option value="<?php echo $rows['type_name']?>"><?php echo $rows['type_name']?></option>
                            <?php
									}
                                }
                            ?>
                        </select>
					</td>
				</tr>
				<tr>
					<th>数 量:</th>
					<td><input name='number' type="number" value='<?php echo $row["number"];?>'  /></td>
				</tr>
				<tr style='height:145px'>
					<th>书本介绍:</th>
					<td><textarea rows='8' cols='40' style='resize:vertical;letter-spacing:2px;' name='mark'><?php echo $row["mark"];?></textarea></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
                        <button type='submit' value='确认修改' class="layui-btn layui-btn-sm">确认修改</button>
						<button type='reset' value='重  置' class="layui-btn layui-btn-sm">恢复默认</button>
<!--						<a href='#'>-->
<!--                            <input type='button' value='返 回' onclick='window.location.href="../books/books_list.php"' class="btn"/>-->
<!--                        </a>-->
					</td>
				</tr>
                <?php
                    }
                ?>
			</table>
		</form>
    </body>
</html>
