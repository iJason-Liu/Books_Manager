<?php
    /*
     * 用户账号注销
     * @Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $usertype = $_SESSION['usertype']; //身份
    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    // print_r($data);
    $id = $data['id'];
    $cardNo = $data['cardNo'];

    if($usertype == '学生'){
        $sql = "delete from student where cardNo='$cardNo'";
    }else if($usertype == '教师'){
        $sql = "delete from teacher where cardNo='$cardNo'";
    }else if($usertype == '图书管理员'){
        $sql = "delete from lib_worker where id='$id'";
    }else{
        $sql = "delete from super_admin where id='$id'";
    }
    $res = mysqli_query($db_connect,$sql);
    if($res){
        echo json_encode(array('code' => 200, 'msg' => '账号注销成功！'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '注销失败！'),JSON_UNESCAPED_UNICODE);
    }
