<?php
    /*
     * session有效时间
     * 判断是否登录再清空session有效时间
     *
     * 判断用户异地登录，限制账号多处登录
     */
    require_once dirname(__DIR__) . '/classes/session_helper.php';
    session_safe_start();

    if (!isset($db_connect)) {
        require_once dirname(__DIR__) . '/config/conn.php';
    }

    $user_id = session_value('user_id');
    $new_sid = session_value('session_id');
    $url = explode('/', $_SERVER['REQUEST_URI']); //获取页面路径
    $url_count = count($url);  //获取当前目录级数

    if ($user_id != '') {
        if (isset($_SESSION['expiretime'])) {
            if ($_SESSION['expiretime'] < time()) {
                if($url_count == 2){
                    echo "<script>alert('会话已过期，请重新登录！');location.href='./oauth/logout'</script>";
                }else if($url_count == 3){
                    echo "<script>alert('会话已过期，请重新登录！');location.href='../oauth/logout'</script>";
                }else if($url_count == 4){
                    echo "<script>alert('会话已过期，请重新登录！');location.href='../../oauth/logout'</script>";
                }
            } else {
                $_SESSION['expiretime'] = time() + 7200;
            }
        }

        $usertype = session_value('usertype');
        if($usertype == '学生'){
            $sql = "select session_id from student where cardNo='$user_id'";
        }else if($usertype == '教师'){
            $sql = "select session_id from teacher where cardNo='$user_id'";
        }else if($usertype == '图书管理员'){
            $sql = "select session_id from lib_worker where id='$user_id'";
        }else if($usertype == '超级管理员'){
            $sql = "select session_id from super_admin where id='$user_id'";
        }else{
            $sql = "select session_id from other_user where id='$user_id'";
        }
        $res = mysqli_query($db_connect, $sql);
        $old_sid = '';
        if ($res) {
            foreach ($res as $session_row){
                $old_sid = $session_row['session_id'];
            }
        }
        if($new_sid != '' && $old_sid != '' && $new_sid != $old_sid){
            if($url_count == 2){
                echo "<script>alert('您的账号已在其他地方登录！');location.href='./oauth/logout';</script>";
            }else if($url_count == 3){
                echo "<script>alert('您的账号已在其他地方登录！');location.href='../oauth/logout';</script>";
            }else if($url_count == 4){
                echo "<script>alert('您的账号已在其他地方登录！');location.href='../../oauth/logout';</script>";
            }
        }
    }
