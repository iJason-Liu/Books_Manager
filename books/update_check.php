<?php
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    echo $id = $_GET['id'];
	echo $name = $_POST['name'];
	echo $price = $_POST['price'];
	echo $author = $_POST['author'];
	echo $publisher = $_POST['publisher'];
	echo $type = $_POST['bookstype'];
	echo $number = $_POST['number'];
	echo $mark = $_POST['mark'];

    //执行sql更新语句
    $sql1 = "update books set book_name='$name',price='$price',author='$author',publisher='$publisher',book_type='$type',number='$number',mark='$mark' where book_id='$id'";
	$result = mysqli_query($db_connect,$sql1);
	// $row = mysqli_affected_rows($result);
	echo $result;
    //重定向页面
	if($result){
		echo "<script>alert('更新书籍信息成功！');location.href='../books/books_detail.php?id=$id';</script>";
	}else{
		echo "<script>alert('更新失败！请检查内容是否合理！');history.back();</script>";
	}

    mysqli_close($db_connect); //关闭数据库资源
?>
