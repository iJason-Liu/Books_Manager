<?php
    /*
     * session有效时间
     * 判断是否登录再清空session有效时间
     *
     * 判断用户异地登录，限制账号多处登录
     */
    //开启session
    session_start();

    $db_connect = mysqli_connect('localhost', 'root', 'root') or die('数据库服务连接失败！');
    mysqli_select_db($db_connect, 'test_db');
    mysqli_query($db_connect,"SET NAMES 'UTF8'");

    $user_id = $_SESSION['user_id'];  //用户id
    $new_sid = $_SESSION['session_id'];  //新登录时的session_id
    if ($user_id != '') {
        if (isset($_SESSION['expiretime'])) {
            if ($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                echo "<script>alert('会话已超时，请重新登录！');location.href='../login/logout.php'</script>"; //登出
                //header('Location: ../login/logout.php?TIMEOUT'); // 登出
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 7200; // 刷新时间戳，增加2小时 7200  1小时 3600  3小时 10800
            }
        }

        if($_SESSION['usertype'] == '学生'){
            $sql = "select session_id from student where cardNo='$user_id'";
        }else if($_SESSION['usertype'] == '教师'){
            $sql = "select session_id from teacher where cardNo='$user_id'";
        }else if($_SESSION['usertype'] == '图书管理员'){
            $sql = "select session_id from lib_worker where id='$user_id'";
        }else if($_SESSION['usertype'] == '超级管理员'){
            $sql = "select session_id from super_admin where id='$user_id'";
        }
        $res = mysqli_query($db_connect, $sql);
        foreach ($res as $item){
            $old_sid = $item['session_id'];  //之前登录的session_id
        }
        // echo $old_sid;
        if($new_sid != $old_sid){
            $url = explode('/', $_SERVER['REQUEST_URI']);
            $url_count = count($url);  //获取当前目录级数
            // session_destroy();
            if($url_count == 2){
                echo "<script>alert('您的账号已在其他地方登录！');location.href='./login/logout.php';</script>";
            }else if($url_count == 3){
                echo "<script>alert('您的账号已在其他地方登录！');location.href='../login/logout.php';</script>";
            }if($url_count == 4){
                echo "<script>alert('您的账号已在其他地方登录！');location.href='../../login/logout.php';</script>";
            }
        }else{
            // echo "正常";
        }
    }
