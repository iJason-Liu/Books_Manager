<?php
    /*
     * 搜索用户进行配置权限
     * 暂不做分页判断，目前获取到的是两个表查询到的数组集合
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小
    $page = ($pageNo-1) * $pageSize; //分页页码
    $keywords = $_GET['keywords']; //关键词

    //查询关键词数据
    $sql1 = "select * from rights where (id='$keywords') or (user_name='$keywords') limit  $page,$pageSize";
    $sql2 = "select * from rights where (id='$keywords') or (user_name='$keywords')";
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