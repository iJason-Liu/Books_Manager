<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    /*
     * 图书删除确认页面（单条操作）
     */
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $id = $_POST['id'];
//    $id = $_POST['data'];die();
    $sql1 = "delete from book_list where book_id='$id'";

    //同时删除对应的图书封面和图书源文件
    $sql2 = "select book_cover,status from book_list where book_id='$id'";
    $res = mysqli_query($db_connect,$sql2);
    while($row = mysqli_fetch_array($res)){
        $coverPath = $row['book_cover']; //封面路径
        $status = $row['status']; //判断图书的状态
    }

    //成功重定向页面
    if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo 403; //暂无权限操作
    }else if($status == 1) {
        echo 402; //在借的图书无法删除
    }else{
        $result = mysqli_query($db_connect,$sql1);
        // $row = mysqli_num_rows($result);  //删除操作影响的行数
        if($result){
            if($coverPath != ''){
                unlink($coverPath); //删除封面文件
            }
            echo 200; //删除成功
        }else{
            echo 401;  //删除失败
        }
    }

    mysqli_close($db_connect); //关闭数据库资源