<?php
    /*
     * 获取用户反馈信息
     * @Jason Liu
     */
    include "../../config/conn.php";
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    // $user_id = $_SESSION['user_id'];  //用户id
    $user_id = $_POST['user_id'];
    $sql = "select * from feedback order by sub_time DESC";
    $result = mysqli_query($db_connect, $sql);
    if($result){
        echo json_encode(array(
            'code' => 200,
            'msg' => 'success',
            'count' => mysqli_num_rows($result),
            'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
        ),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '获取数据失败！'),JSON_UNESCAPED_UNICODE);
    }