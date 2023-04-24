<?php
    /*
     * 人气图书数据
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    //查询数据
    // $sql1 = "select * from book_rank order by click_num limit 90";
    $sql1 = "select * from book_list order by borrow_num desc limit 30";  //查询30条借阅次数最多的图书
    $result = mysqli_query($db_connect, $sql1);

    //定义返回的数据头
    $res = array('code' => 200,'msg' => "success",'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC));
    //输出结果
    echo json_encode($res,JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect); //关闭数据库资源