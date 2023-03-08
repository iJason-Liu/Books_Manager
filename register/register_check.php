<?php
  session_save_path('../session/');
  session_start();
  include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $usertype=$_POST['usertype'];
    $yzm=$_POST['yzm'];

    $sql = "select * from access_user";
    $reg_sql="insert into access_user(user_name,password,user_type)"."values('$username','$password','$usertype')";
    $is_username_equal=0;
    $result=mysqli_query($db_connect,$sql);
    // 判断用户名是否存在
    while($row=mysqli_fetch_array($result)){
        if($username==$row['user_name']){
            $is_username_equal=1;
            break;
        }
    }
    if($yzm!=$_SESSION['check_auth']){
        echo "<script>alert('验证码错误！');history.back();</script>";
    } else if($is_username_equal==1){
        echo "<script>alert('用户名已存在！');history.back();</script>";
    }else if(strlen($_POST['password']) < 6){
        echo "<script>alert('用户密码位数不得小于6位！');history.back();</script>";
    } else if(isset($_POST['submit']) && $username!=''){
        mysqli_query($db_connect,$reg_sql);
        echo "<script>
                alert('恭喜您注册成功！去登录...');
                location.href='../login/login.php?username=$username';
            </script>";
    }
?>