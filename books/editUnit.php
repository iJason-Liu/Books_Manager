<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo "<script>alert('sorry，您暂无权限操作！');history.back();</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    /*
     * 单元格编辑事件的方法
     */
    $id = $_POST['id'];
    $value = $_POST['mark'];
    //echo $_SERVER["QUERY_STRING"];

    //更新对应id的图书简介
    $sql1="update book_list set mark='$value' where book_id='$id'";
    $result=mysqli_query($db_connect,$sql1);

    mysqli_close($db_connect); //关闭数据库资源


