<?php
    /*
     * 搜索图书
     * 前端
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $type = $_POST['keywords_type'];  //搜索类型
    $key = $_POST['keywords'];   //关键词

    /*
     * 0 书名
     * 1 作者
     * 2 ISBN
     * 3 出版社
     * 4 图书类别
     */
    if($type == '0'){
        $sql = "select * from book_list where book_name like '%$key%'";
    }else if($type == '1'){
        $sql = "select * from book_list where author like '$key%'";
    }else if($type == '2'){
        $sql = "select * from book_list where ISBN like '%$key%'";
    }else if($type == '3'){
        $sql = "select * from book_list where publisher='$key'";
    }else if($type == '4'){
        $sql = "select * from book_list where book_type='$key'";
    }

    $result = mysqli_query($db_connect, $sql);
    if($result){
        //定义返回的数据头
        $res = array(
            'code' => 200,
            'msg' => "success",
            'count' => mysqli_num_rows($result),
            'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
        );
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => 'error！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);

