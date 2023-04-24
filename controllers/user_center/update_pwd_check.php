<?php
    /*
     * 用户密码修改
     * @author Jason Liu
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
    $password = md5($data['pwd2']); //密码使用md5加密方式保存

    if($usertype == '学生'){
        $sql = "update student set password='$password' where cardNo='$cardNo'";
    }else if($usertype == '教师'){
        $sql = "update teacher set password='$password' where cardNo='$cardNo'";
    }else if($usertype == '图书管理员'){
        $sql = "update lib_worker set password='$password' where id='$id'";
    }else{
        $sql = "update super_admin set password='$password' where id='$id'";
    }
    $res = mysqli_query($db_connect,$sql);
    if($res){
        echo json_encode(array('code' => 200, 'msg' => '密码修改成功，请重新登录...'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '修改失败！'),JSON_UNESCAPED_UNICODE);
    }
