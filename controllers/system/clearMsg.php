<?php
    /*
     * 清空消息列表
     * @Jason Liu
     */
    include "../../config/conn.php";
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    // $user_id = $_SESSION['user_id'];  //用户id
    $user_id = $_POST['user_id'];
    $sql = "delete from sys_msg where user_id = '$user_id'";
    $result = mysqli_query($db_connect, $sql);

    if($result){
        echo json_encode(array('code' => 200, 'msg' => '消息已清空！', 'count' => mysqli_num_rows($result)),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '操作失败！'),JSON_UNESCAPED_UNICODE);
    }