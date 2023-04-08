<?php
    /*
     * @brief 图书列表的方法页面
     * @Jason Liu
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小

    //查询所有的图书数据
    $sql1 = "select * from book_list";
    $result_data = mysqli_query($db_connect, $sql1);
    //执行sql语句的分页查询语句
    $page = ($pageNo-1) * $pageSize;
    $sql2 = "select * from book_list order by book_id limit $page,$pageSize";
    $result = mysqli_query($db_connect, $sql2);

    //定义返回的数据头
    //$status = array('code' => 200,'msg' => "success");
    $res = array('code' => 200,'msg' => "success",'count' => mysqli_num_rows($result_data),'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC));
    //把两串数据拼起来
    //$res = array_merge($status,$res);
    echo json_encode($res,JSON_UNESCAPED_UNICODE);

    mysqli_close($db_connect); //关闭数据库资源