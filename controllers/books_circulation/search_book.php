<?php
    /*
     * 搜索图书信息模块
     * 关键词类型如下：
     * 0 书名
     * 1 ISBN
     * 2 图书编号
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $keywords = $_GET['keywords']; //关键词
    $keywords_type = $_GET['keywords_type']; //关键词类型

    if($keywords == ''){
        echo json_encode(array('code' => 0, 'msg' => '请输入搜索关键词！'),JSON_UNESCAPED_UNICODE);
    }else {
        //查询数据
        if ($keywords_type == 0) {
            $sql1 = "select * from book_list where book_name like '$keywords'";  //获取
        }else if ($keywords_type == 1) {
            $sql1 = "select * from book_list where ISBN like '$keywords%'";
        }else if ($keywords_type == 2) {
            $sql1 = "select * from book_list where book_id like '$keywords'";
        }

        $result_data = mysqli_query($db_connect, $sql1);
        echo mysqli_error($db_connect); //sql执行错误描述

        //定义返回的数据头
        $res = array('code' => 200, 'msg' => "success", 'data' => mysqli_fetch_all($result_data, MYSQLI_ASSOC));
        //输出结果
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect); //关闭数据库资源