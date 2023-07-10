<?php
    /*
     * 点赞方法
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $id = $_POST['id'];

    $sql1 = "select * from book_comment where comment_id='$id'";
    $comm_data = mysqli_query($db_connect,$sql1);
    $row = mysqli_fetch_array($comm_data);
    //点击一次点赞数+1
    $hits = $row['star']+1;

    mysqli_query($db_connect, "update book_comment set star='$hits' where comment_id='$id'");
    echo json_encode(array('code' => 200, 'msg' => 'success！'),JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect);

