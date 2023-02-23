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

    $sql = "select * from access_user";
    $reg_sql="insert into access_user(username,password,usertype)"."values('$username','$password','$usertype')";
    $is_username_equal=0;
    $result=mysqli_query($db_connect,$sql);
    // 判断用户名是否存在
    while($row=mysqli_fetch_array($result)){
        if($username==$row[username]){
            $is_username_equal=1;
            break;
        }
    }
    if($is_username_equal==1){
        echo "<script>alert('用户名已存在！');history.back();</script>";
    }else if(isset($_POST['submit']) && $username!=''){
        mysqli_query($db_connect,$reg_sql);
        echo "<script>alert('注册成功！去登录...');location.href='../login/login.php'</script>";
    }
?>