<?php
  session_save_path('../session/');
  session_start();
  include '../config/conn.php';
?>
<?php
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $usertype=$_POST['usertype'];
    $yzm=$_POST['yzm'];
    if($yzm!=$_SESSION['check_auth']){
        echo "<script>alert('验证码错误！');history.back();</script>";
    }

    $yz_sql="select * from access_user where username='$username' and password='$password' and usertype='$usertype'";
    $result=mysqli_query($db_connect, $yz_sql);
    $flag=mysqli_num_rows($result);
    if($flag == 0){
        echo "<script>alert('用户名或密码错误,权限不匹配！');history.back();</script>";
    }else{
        $_SESSION['is_flag'] = 2;
        $_SESSION['user'] = $username;
        $_SESSION['usertype'] = $usertype;
        echo "<script>alert('登录成功！');location.href='../administrator/index.php';</script>";
    }
?>