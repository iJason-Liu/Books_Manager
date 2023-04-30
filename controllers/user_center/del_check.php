<?php
    /*
     * 用户账号注销
     * 清除权限表
     * 借阅记录保存
     * @Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $usertype = $_SESSION['usertype']; //身份
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    // print_r($data);
    $id = $data['id'];  //账号id

    $check_sql = "select * from book_borrow where card_id = '$id' and is_back = '0'";
    $flag = mysqli_num_rows(mysqli_query($db_connect, $check_sql));
    if($flag == 1){  //存在未归还的图书，不允许注销
        echo json_encode(array('code' => 0, 'msg' => '注销失败，您还有未归还的图书！'),JSON_UNESCAPED_UNICODE);
    }else{
        if($usertype == '学生'){
            //从两个表中找出相同记录的数据并把两个表中的数据都删除
            $sql = "delete student,rights from student left join rights on student.cardNo=rights.id where student.cardNo='$id'";
        }else if($usertype == '教师'){
            $sql = "delete teacher,rights from teacher left join rights on teacher.cardNo=rights.id where teacher.cardNo='$id'";
        }else if($usertype == '图书管理员'){
            $sql = "delete lib_worker,rights from lib_worker left join rights on lib_worker.id=rights.id where lib_worker.id='$id'";
        }else if($usertype == '超级管理员'){
            $sql = "delete super_admin,rights from super_admin left join rights on super_admin.id=rights.id where super_admin.id='$id'";
        }else{
            $sql = "delete other_user,rights from other_user left join rights on other_user.id=rights.id where other_user.id='$id'";
        }
        $res = mysqli_query($db_connect,$sql);
        if($res){
            echo json_encode(array('code' => 200, 'msg' => '账号注销成功！！！'),JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(array('code' => 0, 'msg' => '注销失败，请稍后再试！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect);
