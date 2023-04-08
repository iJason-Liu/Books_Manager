<?php
    /*
     * 用户登录验证
     */
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    include "../classes/getIP.php";
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $account = $_POST['account']; //id或借阅卡号
    $password = md5($_POST['password']);  //密码
    $usertype = $_POST['usertype'];  //用户类型
    $yzm = $_POST['yzm'];  //验证码
    $log_time = date('Y:m:d H:i:s', time());  //登录时间，消息添加时间

    //把session_id存入本地session
    $session_id = session_id();
    $_SESSION['session_id'] = $session_id;

    if($usertype == '学生'){
        $yz_sql = "select * from student where cardNo='$account' and password='$password' and user_type='$usertype'";
        $set_sid = "update student set session_id='$session_id',log_time='$log_time' where cardNo='$account'";
    }else if($usertype == '教师'){
        $yz_sql = "select * from teacher where cardNo='$account' and password='$password' and user_type='$usertype'";
        $set_sid = "update teacher set session_id='$session_id',log_time='$log_time' where cardNo='$account'";
    }else if($usertype == '图书管理员'){
        $yz_sql = "select * from lib_worker where id='$account' and password='$password' and user_type='$usertype'";
        $set_sid = "update lib_worker set session_id='$session_id',log_time='$log_time' where id='$account'";
    }else if($usertype == '超级管理员'){
        $yz_sql = "select * from super_admin where id='$account' and password='$password' and user_type='$usertype'";
        $set_sid = "update super_admin set session_id='$session_id',log_time='$log_time' where id='$account'";
    }
    $result = mysqli_query($db_connect, $yz_sql);
    $flag = mysqli_num_rows($result);
    if($yzm != $_SESSION['check_auth']){
        echo "<script>alert('验证码错误！');history.back();</script>";
    }else if($flag == 0){
        echo "<script>alert('借阅卡号或密码错误,权限不匹配！');history.back();</script>";
    }else{
        $_SESSION['is_login'] = 2; //登录状态
        $_SESSION['usertype'] = $usertype; //登录用户身份

        while ($row = mysqli_fetch_array($result)) {
            if($usertype == '超级管理员'){
                $username = $row['username']; //用户名
            }else{
                $username = $row['name']; //用户名
            }
        }
        $_SESSION['user'] = $username;  //登录用户名name
        $_SESSION['user_id'] = $account;  //登录用户id 借阅卡号

        //取随机头像
        $res_logo = mysqli_query($db_connect, 'select * from avatar order by rand() limit 1');
        while ($k = mysqli_fetch_array($res_logo)){
            $logo = $k['path'];
        }
        $_SESSION['src'] = $logo; //把随机头像存入session

        $sender = "系统消息";  //消息发送者
        $content = "Hello！".$username."，您于".$log_time."成功登录系统，登录IP：".$realip;  //消息内容
        //登录成功添加一条系统消息
        $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$account','$sender','$content','$add_time')";
        $msg_res = mysqli_query($db_connect, $msg_sql);
        if($msg_res){
            // echo "发送消息成功！";
        }

        //把session_id和登录时间存入数据表
        mysqli_query($db_connect, $set_sid);
        //登录成功设置session过期时间为3个小时
        $_SESSION['expiretime'] = time() + 10800;

        echo "<script>alert('登录成功！');location.href='../administrator/index.php';</script>";
    }

    mysqli_close($db_connect); //关闭数据库资源