<?php
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
//    echo $page = $_POST['page'];
//    echo $limit = $_POST['limit'];
//图书列表的方法页面
    //执行sql语句的查询语句
    $sql1 = "select * from book_list";
    $result = mysqli_query($db_connect, $sql1);

    //定义返回的数据头
    //$status = array('code' => 200,'msg' => "success");
    $res = array('code' => 200,'msg' => "success",'count' => mysqli_num_rows($result),'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC));
    //把两串数据拼起来
    //$res = array_merge($status,$res);
    echo json_encode($res,JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect); //关闭数据库资源