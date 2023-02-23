<?php
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $id = $_GET['id'];
    $sql1 = "delete from books where book_id='$id'";
    $result = mysqli_query($db_connect,$sql1);
    // $row = mysqli_num_rows($result);
    //重定向页面
	if($result){
		echo "<script>alert('已删除！');location.href='../books/books_list.php';</script>";
	}else{
		echo "<script>alert('删除失败！');</script>";
	}

    mysqli_close($db_connect); //关闭数据库资源
?>