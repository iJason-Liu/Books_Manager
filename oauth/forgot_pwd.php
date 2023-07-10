<?php
    /*
     * 重置密码
     *  @Jason Liu
     */
    session_start();
    include '../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");

    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);
    $user_id = $data['account'];  //账号
    $pwd = md5($data['pwd2']);  //新密码
    $email_yzm = $data['email_yzm'];  //用户输入的验证码
    $time = date('Y-m-d H:i:s', time());  //操作时间  更新
    $code = $_SESSION['reset_code'];  //发送到邮箱的验证码

    if($email_yzm != $code){
        echo json_encode(array('code' => 400, 'msg' => '验证码错误！'),JSON_UNESCAPED_UNICODE);
        exit();
    }

    // 使用账号去查 5 个表，查到哪一个为true，就更新那个表中的对应读者密码
    // 五个表中的id都是唯一的，不存在重复
    $check_sql = "select * from student where cardNo = '$user_id'";
    $flag = mysqli_num_rows(mysqli_query($db_connect, $check_sql));

    $check_sql1 = "select * from teacher where cardNo = '$user_id'";
    $flag1 = mysqli_num_rows(mysqli_query($db_connect, $check_sql1));

    $check_sql2 = "select * from lib_worker where id = '$user_id'";
    $flag2 = mysqli_num_rows(mysqli_query($db_connect, $check_sql2));

    $check_sql3 = "select * from super_admin where id = '$user_id'";
    $flag3 = mysqli_num_rows(mysqli_query($db_connect, $check_sql3));

    $check_sql4 = "select * from other_user where id = '$user_id'";
    $flag4 = mysqli_num_rows(mysqli_query($db_connect, $check_sql4));

    if($flag == 1){
        $res = mysqli_query($db_connect, "update student set password='$pwd',updatetime='$time' where cardNo='$user_id'");
    }else if($flag1 == 1){
        $res = mysqli_query($db_connect, "update teacher set password='$pwd',updatetime='$time' where cardNo='$user_id'");
    }else if($flag2 == 1){
        $res = mysqli_query($db_connect, "update lib_worker set password='$pwd',updatetime='$time' where id='$user_id'");
    }else if($flag3 == 1){
        $res = mysqli_query($db_connect, "update super_admin set password='$pwd',updatetime='$time' where id='$user_id'");
    }else if($flag4 == 1){
        $res = mysqli_query($db_connect, "update other_user set password='$pwd',updatetime='$time' where id='$user_id'");
    }

    if($res){
        echo json_encode(array('code' => 200, 'msg' => '密码已重置成功，请登录！'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '密码重置失败，请稍后再试！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);