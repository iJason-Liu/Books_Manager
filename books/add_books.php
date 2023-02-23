<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if($_SESSION['is_flag']!=2){
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }

    // 查询图书类别表
    $sql1="select * from bookstype";
    $result=mysqli_query($db_connect,$sql1);
?>
<html>
	<head>
		<title>添加新图书</title>
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
		<h2 align='center' style='margin-top:5%'>添 加 新 图 书</h2>
		<form action='add_books_check.php' method='post'>
			<table align='center'>
				<tr>
					<th style='width:120px'>书本名称:</th>
					<td><input name='name' required value='' placeholder="请输入图书名称，请手动添加书名号" style='width:300px' /></td>
				</tr>
				<tr>
					<th>书本价格:</th>
					<td><input name='price' type="number" required placeholder="请输入价格" value='' style='width:300px' /></td>
				</tr>
				<tr>
					<th>书本作者:</th>
					<td><input name='author' required value='' placeholder="请输入作者" style='width:300px' /></td>
				</tr>
				<tr>
					<th>出版社:</th>
					<td><input name='publisher' required value='' placeholder="请输入图书出版社" style='width:300px' /></td>
				</tr>
				<tr>
					<th>图书类别:</th>
					<td>
                        <select class="sel" name="bookstype" size="1">
                            <?php
                                while($row=mysqli_fetch_array($result)){
                            ?>
                            <option value="<?php echo $row['type_name']?>"><?php echo $row['type_name']?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
				</tr>
				<tr>
					<th>数量:</th>
					<td><input name='number' required type="number" value='' placeholder="请输入数量" style='width:300px' /></td>
				</tr>
				<tr style='height:145px'>
					<th>书本介绍:</th>
					<td><textarea rows='8' cols='40' required placeholder="请输入介绍" style='resize:vertical;letter-spacing:2px;' name='mark'></textarea></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
						<input type='submit' name="add" value='确 认' class="btn"/>
						<input type='reset' value='重  置' class="btn"/>
                        <a href='#'>
                            <input type='button' value='返 回' onclick='window.location.href="../books/books_list.php"' class="btn"/>
                        </a>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>