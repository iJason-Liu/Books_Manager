<?php
    /*
     * 用户发表书评
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $name = $_SESSION['user'];   //用户名
    $avatar = $_SESSION['avatar'];
    $book_id = $_POST['book_id'];   //用户id
    $user_id = $_POST['user_id'];  //图书编号
    $sub_time = date('Y-m-d', time());  //发表时间
    $comment = $_POST['comment'];  //发表内容
    // die();

    $res = mysqli_query($db_connect, "select * from book_list where book_id='$book_id'");
    while ($row = mysqli_fetch_array($res)){
        $book_name = $row['book_name'];
    }

    $sql1 = "insert into book_comment(user_id,book_id,user_name,avatar,book_name,content,createtime) values ('$user_id','$book_id','$name','$avatar','$book_name','$comment','$sub_time')";
    $result = mysqli_query($db_connect, $sql1);
    //判断是否执行成功
    if ($result) {
        echo json_encode(array('code' => 200, 'msg' => '发表成功！'), JSON_UNESCAPED_UNICODE);  //删除成功
    } else {
        echo json_encode(array('code' => 0, 'msg' => '发表失败，请稍后再试！'), JSON_UNESCAPED_UNICODE);
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源