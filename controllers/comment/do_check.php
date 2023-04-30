<?php
    /*
     * 评论审核操作
     *  @Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include "../../classes/check_rights.php";

    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");

    $comment_id = $_POST['comment_id'];  //评论id
    $status = $_POST['status'];  //状态
    $content = $_POST['audit'];  //审核意见
    $time = date('Y-m-d H:i:s', time());  //审核时间

    if($item['comment_center'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        $sql = "update book_comment set approve_content='$content',approve_status='$status',approve_time='$time' where comment_id='$comment_id'";
        $result = mysqli_query($db_connect, $sql);
        if ($result) {
            echo json_encode(array('code' => 200, 'msg' => '审核完成！'), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('code' => 0, 'msg' => '操作失败，请稍后再试！'), JSON_UNESCAPED_UNICODE);
        }
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源