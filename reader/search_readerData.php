<?php
    /*
     * 搜索读者数据
     * 暂不做分页判断，目前获取到的是两个表查询到的数组集合
     */
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小
    $page = ($pageNo-1) * $pageSize; //分页页码
    $keywords = $_GET['keywords']; //关键词

    //查询数据
    $sql1 = "select * from student where (cardNo='$keywords') or (name='$keywords')";
    $sql2 = "select * from teacher where (cardNo='$keywords') or (name='$keywords')";
    $result = mysqli_query($db_connect, $sql1);
    $result2 = mysqli_query($db_connect, $sql2);
    $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $row2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
    $row_data = array_merge($row,$row2);
//    var_dump($row_data);
//    die();

    //定义返回的数据头
    $res = array('code' => 200,'msg' => "success",'count' => count($row_data),'data'=> $row_data);
    //输出结果
    echo json_encode($res,JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect); //关闭数据库资源