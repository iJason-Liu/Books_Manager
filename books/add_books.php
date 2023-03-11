<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if($_SESSION['is_flag']!=2){
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    // 查询图书类别表
    $sql1="select * from book_type";
    $result=mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>
	<head>
		<title>添加新图书</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
		<h1 align="center" style='margin-top:10px'>添加新图书</h1>
        <hr>
		<form action='../books/add_books_check.php' method='post'>
			<table class="tab">
				<tr>
					<th style='width:120px'>书本名称:</th>
					<td><input name='name' required value='' placeholder="请输入图书名称，请手动添加书名号" /></td>
				</tr>
				<tr>
					<th>书本价格:</th>
					<td><input name='price' type="number" required placeholder="请输入价格" value=''  /></td>
				</tr>
				<tr>
					<th>书本作者:</th>
					<td><input name='author' required value='' placeholder="请输入作者"  /></td>
				</tr>
				<tr>
					<th>出 版 社:</th>
					<td><input name='publisher' required value='' placeholder="请输入图书出版社"  /></td>
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
					<th>数 量:</th>
					<td><input name='number' required type="number" value='' placeholder="单位：本"  /></td>
				</tr>
				<tr style='height:145px'>
					<th>书本介绍:</th>
					<td><textarea rows='8' cols='40' required placeholder="请输入介绍" style='resize:vertical;letter-spacing:2px;' name='mark'></textarea></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
                        <button type='submit' name="add" value='确 认' class="layui-btn layui-btn-sm">确 认</button>
                        <button type='reset' value='重  置' class="layui-btn layui-btn-sm">重 置</button>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>