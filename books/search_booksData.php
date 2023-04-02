<?php
    /*
     * 搜索图书数据
     * 关键词类型如下：
     * 0 书名
     * 1 作者
     * 2 ISBN
     * 3 出版社
     * 4 图书类别
     * 5 藏书位置
     */
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $pageNo = $_GET['page']; //页码
    $pageSize = $_GET['limit']; //每页大小
    $page = ($pageNo-1) * $pageSize; //分页页码

    $keywords = $_GET['keywords']; //关键词
    $keywords_type = $_GET['keywords_type']; //关键词类型

    if($keywords == ''){
//        $randSql = "select * from book_list order by rand() limit 1";  //随机查询一条数据
//        $randData = mysqli_query($db_connect, $randSql);
        echo json_encode(array('code' => 200, 'msg' => '随机数据', 'count' => 0, 'data' => ''),JSON_UNESCAPED_UNICODE);
    }else {
        //查询数据
        if ($keywords_type == 0) {
            $sql1 = "select * from book_list where book_name like '%$keywords%'";  //获取
            $sql2 = $sql1;  //获取查询到的总条数
        } else if ($keywords_type == 1) {
            $sql1 = "select * from book_list where author='$keywords' limit $page,$pageSize";
            $sql2 = "select * from book_list where author='$keywords'";
        } else if ($keywords_type == 2) {
            $sql1 = "select * from book_list where ISBN like '$keywords%'";
            $sql2 = $sql1;
        } else if ($keywords_type == 3) {
            $sql1 = "select * from book_list where publisher='$keywords' limit $page,$pageSize";
            $sql2 = "select * from book_list where publisher='$keywords'";
        } else if ($keywords_type == 4) {
            $sql1 = "select * from book_list where book_type='$keywords' limit $page,$pageSize";
            $sql2 = "select * from book_list where book_type='$keywords'";
        } else if ($keywords_type == 5) {
            //对关键词进行处理
            //$stackname = substr($keywords,0,strrpos($keywords,"_")); //书库名称
            //$stacksite = substr($keywords,strrpos($keywords,"_")+1);  //书库位置
            $sql1 = "select * from book_list where save_position like '%$keywords%' limit $page,$pageSize";
            $sql2 = "select * from book_list where save_position like '%$keywords%'";
        }

        $result_data = mysqli_query($db_connect, $sql1);
        $result = mysqli_query($db_connect, $sql2);
        echo mysqli_error($db_connect); //sql执行错误描述

        //定义返回的数据头
        $res = array('code' => 200, 'msg' => "success", 'count' => mysqli_num_rows($result), 'data' => mysqli_fetch_all($result_data, MYSQLI_ASSOC));
        //输出结果
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect); //关闭数据库资源