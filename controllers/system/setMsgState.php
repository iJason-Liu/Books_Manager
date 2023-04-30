<?php
    /*
     * 设置用户消息为已读
     * @Jason Liu
     */
    include "../../config/conn.php";
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    // $user_id = $_SESSION['user_id'];  //用户id
    $user_id = $_POST['user_id'];
    // $msg_id = $_POST['msg_id'];  //暂不设置单条消息状态
    $sql = "update sys_msg set state = '1' where user_id = '$user_id'";
    $result = mysqli_query($db_connect, $sql);

    if($result){
        echo json_encode(array('code' => 200, 'msg' => 'success'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '失败'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);