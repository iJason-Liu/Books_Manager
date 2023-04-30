<?php
    /*
     * 读者信息更新
     * @author Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include "../../classes/check_rights.php";

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    // print_r($data);die();
    $id = $data['id'];
    $name = $data['name'];
    $pwd = md5($data['pwd']);
    $sex = $data['sex'];
    $user_type = $data['user_type'];
    $department = $data['department'];
    $class = $data['class'];
    $mobile = $data['mobile'];
    $limit = $data['limit'];  //借阅数量
    $updatetime = date('Y-m-d H:i:s', time());

    if($item['reader_list'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        if ($user_type == '学生') {
            $sql = "update student set name='$name',password='$pwd',sex='$sex',department='$department',class='$class',mobile='$mobile',borrow_limit='$limit',updatetime='$updatetime' where cardNo='$id'";
        } else if ($user_type == '教师') {
            $sql = "update teacher set name='$name',password='$pwd',sex='$sex',department='$department',class='$class',mobile='$mobile',borrow_limit='$limit',updatetime='$updatetime' where cardNo='$id'";
        } else {
            $sql = "update other_user set name='$name',password='$pwd',sex='$sex',mobile='$mobile',borrow_limit='$limit',updatetime='$updatetime' where id='$id'";
        }
        $res = mysqli_query($db_connect, $sql);
        // echo mysqli_error($db_connect);
        if ($res) {
            echo json_encode(array('code' => 200, 'msg' => '恭喜您，信息修改成功！'), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('code' => 0, 'msg' => '修改失败！'), JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect);
