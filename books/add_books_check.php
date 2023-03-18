<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
	echo $name = $_POST['name'];
	echo $price = $_POST['price'];
	echo $author = $_POST['author'];
	echo $publisher = $_POST['publisher'];
	echo $type = $_POST['bookstype'];
	echo $number = $_POST['number'];
	echo $mark = $_POST['mark'];
    $create_time = date('Y-m-d h:i:s', time()); //添加时间

    $sql = "select * from book_list";
    $add_sql="insert into book_list(book_name,price,author,publisher,book_type,number,mark)"."values('$name','$price','$author','$publisher','$type','$number','$mark')";
    $is_book_name_equal=0;  //判断图书是否存在
    $result=mysqli_query($db_connect,$sql);
    // 判断用户名是否存在
    while($row=mysqli_fetch_array($result)){
        if($name==$row[book_name]){
            $is_book_name_equal=1;
            break;
        }
    }
    if($is_book_name_equal==1){
        echo "<script>alert('所添加图书已经存在！！！');history.back();</script>";
    }else if(isset($_POST['add']) && $name!=''){
        mysqli_query($db_connect,$add_sql);
        echo "<script>alert('添加成功！');parent.location.replace('../books/books_test.php');</script>";
    }
