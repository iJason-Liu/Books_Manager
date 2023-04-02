<?php
    /*
     * 搜索馆员数据
     */
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小
    $page = ($pageNo-1) * $pageSize; //分页页码
    $keywords = $_GET['keywords']; //关键词

    //查询数据
    $sql1 = "select * from lib_worker where (id='$keywords') or (name='$keywords') limit $page,$pageSize";
    $sql2 = "select * from lib_worker where (id='$keywords') or (name='$keywords')";
    $result = mysqli_query($db_connect, $sql1);  //获取分页查询数据
    $result2 = mysqli_query($db_connect, $sql2);  //获取查询到的总行数

    //定义返回的数据头
    $res = array('code' => 200,'msg' => "success",'count' => mysqli_num_rows($result2),'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC));
    //输出结果
    echo json_encode($res,JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect); //关闭数据库资源