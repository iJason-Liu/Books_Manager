<?php
include '../config/conn.php';
// 设置文档类型：，utf-8支持中文文档
header("Content-Type:text/html;charset=utf-8");
$id = $_POST['id'];
$value = $_POST['mark'];
//echo $id;
//echo $value;
//echo $_SERVER["QUERY_STRING"];

//更新对应id的图书简介
$sql1="update book_list set mark='$value' where book_id='$id'";
$result=mysqli_query($db_connect,$sql1);

mysqli_close($db_connect); //关闭数据库资源


