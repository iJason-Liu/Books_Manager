<?php
    /*
     * 用户信息更新
     * @author Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    // print_r($data);
    $id = $data['id'];  //账号
    $name = $data['name'];
    $sex = $data['sex'];
    $usertype = $data['usertype']; //身份
    $department = $data['department'];
    $class = $data['class'];
    $mobile = $data['mobile'];
    // die();

    if($usertype == '学生'){
        //这一操作其实就是同时更新两个表id相同的唯一的一条数据，暂时不用
        //$sql = "update access_user,student set user_name='$name',name='$name',sex='$sex',department='$department',class='$class',mobile='$mobile' where access_user.cardNo= '$cardNo' and student.cardNo='$cardNo'";
        $sql = "update student set name='$name',sex='$sex',department='$department',class='$class',mobile='$mobile' where cardNo='$id'";
    }else if($usertype == '教师'){
        $sql = "update teacher set name='$name',sex='$sex',department='$department',class='$class',mobile='$mobile' where cardNo='$id'";
    }else if($usertype == '图书管理员'){
        $sql = "update lib_worker set name='$name',sex='$sex',mobile='$mobile' where id='$id'";
    }else{
        $sql = "update other_user set name='$name',sex='$sex',mobile='$mobile' where id='$id'";
    }
    $res = mysqli_query($db_connect,$sql);
    if($res){
        echo json_encode(array('code' => 200, 'msg' => '信息更新成功！'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '修改失败！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);
