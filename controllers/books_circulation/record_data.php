<?php
    /*
     * 搜索读者的借阅记录
     * 关键词类型如下：
     * 0 借阅卡号
     * 1 图书编号
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $keywords = $_GET['keywords']; //关键词
    $keywords_type = $_GET['keywords_type']; //关键词类型

    //查询数据
    if ($keywords_type == 0) {
        $sql1 = "select * from book_borrow where card_id = '$keywords' order by is_back";
    } else if ($keywords_type == 1) {
        $sql1 = "select * from book_borrow where book_id = '$keywords' order by is_back";
    }

    $result_data = mysqli_query($db_connect, $sql1);
    echo mysqli_error($db_connect); //sql执行错误描述

    //定义返回的数据头
    $res = array(
        'code' => 200,
        'msg' => "success",
        'count' => mysqli_num_rows($result_data),
        'data' => mysqli_fetch_all($result_data, MYSQLI_ASSOC)
    );
    //输出结果
    if($result_data){
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect); //关闭数据库资源