<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $file = $_FILES["file"];
    $filename = $file["name"];
    $path = "../upload/bookCover/";

    //上传的文件路径，可用于存入数据库的book_cover字段
    echo $filepath = $path.$filename;
    $res = move_uploaded_file($file["tmp_name"],$filepath);
    if($res){
       echo "<script>alert('文件上传成功！')</script>";
        //执行sql更新语句
        $sql1 = "update book_list set book_cover='$filepath' where book_id=10019";
        $result = mysqli_query($db_connect,$sql1);
        //重定向页面
        if($result){
            echo "<script>alert('更新图书信息成功！');</script>";
        }else{
            echo "<script>alert('更新失败！请检查内容是否合理！');location.href='../books/books_test.php';</script>";
        }
    }else{
        echo "<script>alert('文件上传失败！');history.back()</script>";
    }
    mysqli_close($db_connect); //关闭数据库资源