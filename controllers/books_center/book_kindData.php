<?php
    /*
     * 获取所有图书类别数据
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    //查询所有数据
    $sql1 = "select * from book_kind order by type_id";
    $result = mysqli_query($db_connect, $sql1);

    if($result){
        //定义返回的数据头
        $res = array(
            'code' => 200,
            'msg' => "success",
            'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
        );
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => 'failure！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect); //关闭数据库资源