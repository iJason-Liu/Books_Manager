<?php
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
     $id = $_GET['id'];
	 $name = $_POST['name'];
	 $price = $_POST['price'];
	 $author = $_POST['author'];
	 $publisher = $_POST['publisher'];
	 $type = $_POST['bookstype'];
	 $number = $_POST['number'];
	 $mark = $_POST['mark'];

    //执行sql更新语句
    $sql1 = "update book_list set book_name='$name',price='$price',author='$author',publisher='$publisher',book_type='$type',number='$number',mark='$mark' where book_id='$id'";
	$result = mysqli_query($db_connect,$sql1);
	// $row = mysqli_affected_rows($result);
//	echo $result;
    //重定向页面
	if($result){
		echo "<script>alert('更新图书信息成功！');parent.location.replace('../books/books_test.php');</script>";
	}else{
		echo "<script>alert('更新失败！请检查内容是否合理！');history.back();</script>";
	}
//	if(isset($_POST['submit'])){
//
//	}
    mysqli_close($db_connect); //关闭数据库资源
?>
