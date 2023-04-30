<?php
    /*
     * 搜索新闻或公告数据，获取到的是两个表查询到的数组集合
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小
    $page = ($pageNo-1) * $pageSize; //分页页码
    $keywords = $_GET['keywords']; //关键词

    //根据关键词查询数据
    $sql1 = "select * from news_notice where (title like '%$keywords%') or (author like '$keywords%') limit $page,$pageSize";
    $sql2 = "select * from news_notice where (title like '%$keywords%') or (author like '$keywords%')";
    $result = mysqli_query($db_connect, $sql1);
    $result2 = mysqli_query($db_connect, $sql2);  //总行数

    //定义返回的数据头
    $res = array(
        'code' => 200,
        'msg' => "success",
        'count' => mysqli_num_rows($result2),
        'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
    );
    //输出结果
    echo json_encode($res,JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect); //关闭数据库资源