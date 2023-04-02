<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $account = $_POST['account']; //用户名或者借阅卡号
    $password = md5($_POST['password']);
    $usertype = $_POST['usertype'];
    $yzm = $_POST['yzm'];

    if($usertype == '学生'){
        $yz_sql = "select * from student where cardNo='$account' and password='$password' and user_type='$usertype'";
    }else if($usertype == '教师'){
        $yz_sql = "select * from teacher where cardNo='$account' and password='$password' and user_type='$usertype'";
    }else if($usertype == '图书管理员'){
        $yz_sql = "select * from lib_worker where id='$account' and password='$password' and user_type='$usertype'";
    }else if($usertype == '超级管理员'){
        $yz_sql = "select * from super_admin where id='$account' and password='$password' and user_type='$usertype'";
    }
    $result = mysqli_query($db_connect, $yz_sql);
    $flag = mysqli_num_rows($result);
    if($yzm != $_SESSION['check_auth']){
        echo "<script>alert('验证码错误！');history.back();</script>";
    }else if($flag == 0){
        echo "<script>alert('用户名或密码错误,权限不匹配！');history.back();</script>";
    }else{
        $_SESSION['is_login'] = 2; //登录状态
        $_SESSION['usertype'] = $usertype; //登录用户身份

        while ($row = mysqli_fetch_array($result)) {
            if($usertype == '超级管理员'){
                $username = $row['username']; //用户名
            }else{
                $username = $row['name']; //用户名
            }
            if($usertype == '图书管理员' || $usertype == '超级管理员'){
                $cardNo = $row['id'];  //id
            }else{
                $cardNo = $row['cardNo'];  //借阅卡号
            }
        }
        $_SESSION['user'] = $username;  //用户名name
        $_SESSION['cardNo'] = $cardNo;  //用户id 借阅卡号
        echo "<script>alert('登录成功！');location.href='../administrator/index.php';</script>";

        //取随机头像
        $res_logo = mysqli_query($db_connect, 'select * from avatar order by rand() limit 1');
        while ($k = mysqli_fetch_array($res_logo)){
            $logo = $k['path'];
        }
        $_SESSION['src'] = $logo; //存入session

        //登录成功设置session过期时间为3个小时
        $_SESSION['expiretime'] = time() + 10800;
    }

    mysqli_close($db_connect); //关闭数据库资源