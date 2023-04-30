<?php
    /*
     * 获取用户消息列表
     * @Jason Liu
     */
    include "../../config/conn.php";
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    // $user_id = $_SESSION['user_id'];  //用户id
    $user_id = $_POST['user_id'];
    $sql = "select * from sys_msg where user_id = '$user_id' order by createtime DESC limit 50";
    $result = mysqli_query($db_connect, $sql);
    $sql2 = "select * from sys_msg where user_id = '$user_id' and state = '0'";
    $result2 = mysqli_query($db_connect, $sql2);
    // state是判断未读消息的条数状态

    if($result){
        echo json_encode(array(
            'code' => 200,
            'msg' => 'success',
            'state' => mysqli_num_rows($result2),
            'count' => mysqli_num_rows($result2),
            'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
        ),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '获取数据失败！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);