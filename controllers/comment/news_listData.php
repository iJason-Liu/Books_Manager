<?php
    /*
     * 获取所有新闻和公告数据
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小

    //查询新闻表和公告表数据
    $sql1 = "select * from news_notice";
    $result_data = mysqli_query($db_connect, $sql1);
    // echo mysqli_error($db_connect);
    //执行sql语句的分页查询语句
    $page = ($pageNo-1) * $pageSize;
    $sql2 = "select * from news_notice order by sub_time desc limit $page,$pageSize";
    $result = mysqli_query($db_connect, $sql2);

    if($result){
        //定义返回的数据头
        $res = array(
            'code' => 200,
            'msg' => "success",
            'count' => mysqli_num_rows($result_data),
            'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
        );
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => 'failure！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect); //关闭数据库资源