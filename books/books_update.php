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

	// 查询图书类别语句
	$sql2="select * from bookstype";
    $result1=mysqli_query($db_connect,$sql2);

    mysqli_close($db_connect); //关闭数据库资源
?>
<html>
	<head>
		<title>更新图书信息</title>
		<style>
			td {
				height: 45px;
			}
            textarea{
                font-size: 16px;
            }
            .btn{
                width:80px;
                height:25px;
                background-color:lightseagreen;
                cursor: pointer;
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
		<h2 align='center' style='margin-top:5%'>更 新 图 书 信 息</h2>
		<form action='update_check.php?id=<?php echo $id;?>' method='post'>
            <?php
                while($row = mysqli_fetch_array($result)){
					$type = $row['book_type'];
            ?>
			<table align='center'>
				<tr>
					<th style='width:120px'>书本名称:</th>
					<td><input name='name' value='<?php echo $row["book_name"];?>' style='width:300px' /></td>
				</tr>
				<tr>
					<th>书本价格:</th>
					<td><input name='price' type="number" value='<?php echo $row["price"];?>' style='width:300px' /></td>
				</tr>
				<tr>
					<th>书本作者:</th>
					<td><input name='author' value='<?php echo $row["author"];?>' style='width:300px' /></td>
				</tr>
				<tr>
					<th>出版社:</th>
					<td><input name='publisher' value='<?php echo $row["publisher"];?>' style='width:300px' /></td>
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
					<th>数量:</th>
					<td><input name='number' type="number" value='<?php echo $row["number"];?>' style='width:300px' /></td>
				</tr>
				<tr style='height:145px'>
					<th>书本介绍:</th>
					<td><textarea rows='8' cols='40' style='resize:vertical;letter-spacing:2px;' name='mark'><?php echo $row["mark"];?></textarea></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
						<input type='submit' value='确认修改' class="btn"/>
						<input type='reset' value='重  置' class="btn"/>
						<a href='#'>
                            <input type='button' value='返 回' onclick='window.location.href="../books/books_list.php"' class="btn"/>
                        </a>
					</td>
				</tr>
                <?php
                    }
                ?>
			</table>
		</form>
	</body>
</html>
