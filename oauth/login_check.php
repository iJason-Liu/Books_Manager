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

    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);
    $account = $data['account']; //id或借阅卡号
    $password = md5($data['password']);  //密码
    $usertype = $data['usertype'];  //用户类型
    $yzm = $data['yzm'];  //验证码
    // $_SESSION['check_yzm'];

    $log_time = date('Y-m-d H:i:s', time());  //登录时间，消息添加时间
    $log_carrier = getip($realip);  //获取登录运营商  $realip是登录ip地址

    //把session_id存入本地session中
    $session_id = session_id();
    $_SESSION['session_id'] = $session_id;

    //验证账号sql 设置登录session的sql 用户头像sql
    if($usertype == '学生'){
        $yz_sql = "select * from student where cardNo='$account' and password='$password' and user_type='$usertype'";
        $exits_sql = "select * from student where cardNo='$account'";
        $set_sid = "update student set session_id='$session_id',log_time='$log_time',log_ip='$realip',log_carrier='$log_carrier' where cardNo='$account'";
        $avatar_sql = "select avatar from student where cardNo='$account'";
    }else if($usertype == '教师'){
        $yz_sql = "select * from teacher where cardNo='$account' and password='$password' and user_type='$usertype'";
        $exits_sql = "select * from teacher where cardNo='$account'";
        $set_sid = "update teacher set session_id='$session_id',log_time='$log_time',log_ip='$realip',log_carrier='$log_carrier' where cardNo='$account'";
        $avatar_sql = "select avatar from teacher where cardNo='$account'";
    }else if($usertype == '图书管理员'){
        $yz_sql = "select * from lib_worker where id='$account' and password='$password' and user_type='$usertype'";
        $exits_sql = "select * from lib_worker where id='$account'";
        $set_sid = "update lib_worker set session_id='$session_id',log_time='$log_time',log_ip='$realip',log_carrier='$log_carrier' where id='$account'";
        $avatar_sql = "select avatar from lib_worker where id='$account'";
    }else if($usertype == '超级管理员'){
        $yz_sql = "select * from super_admin where id='$account' and password='$password' and user_type='$usertype'";
        $exits_sql = "select * from super_admin where id='$account'";
        $set_sid = "update super_admin set session_id='$session_id',log_time='$log_time',log_ip='$realip',log_carrier='$log_carrier' where id='$account'";
        $avatar_sql = "select avatar from super_admin where id='$account'";
    }else{
        $yz_sql = "select * from other_user where id='$account' and password='$password' and user_type='$usertype'";
        $exits_sql = "select * from other_user where id='$account'";
        $set_sid = "update other_user set session_id='$session_id',log_time='$log_time',log_ip='$realip',log_carrier='$log_carrier' where id='$account'";
        $avatar_sql = "select avatar from other_user where id='$account'";
    }
    $result = mysqli_query($db_connect, $yz_sql);
    $flag = mysqli_num_rows($result);  //判断账号密码身份是否匹配
    $flag_exit = mysqli_num_rows(mysqli_query($db_connect, $exits_sql)); //判断账号是否存在
    if($yzm != $_SESSION['check_yzm']){
        echo json_encode(array('code' => 403, 'msg' => '验证码错误！'),JSON_UNESCAPED_UNICODE); //无权限
    }else if($flag_exit == 0){
        echo json_encode(array('code' => 403, 'msg' => '该账号不存在，请先注册！'),JSON_UNESCAPED_UNICODE); //无权限
    }else if($flag == 0){
        echo json_encode(array('code' => 403, 'msg' => '借阅卡号或密码错误，身份不匹配！'),JSON_UNESCAPED_UNICODE); //无权限
    }else{
        $_SESSION['is_login'] = 2; //登录状态
        $_SESSION['usertype'] = $usertype; //登录用户身份

        while ($row = mysqli_fetch_array($result)) {
            if($usertype == '超级管理员'){
                $username = $row['username']; //用户名
            }else{
                $username = $row['name']; //用户名
            }
            $lasttime = $row['log_time'];  //账号上次登录时间
        }
        $_SESSION['user'] = $username;  //登录用户名name
        $_SESSION['user_id'] = $account;  //登录用户id 借阅卡号

        //取随机头像
        $res_logo = mysqli_query($db_connect, 'select * from avatar order by rand() limit 1');
        while ($k = mysqli_fetch_array($res_logo)){
            $logo = $k['path'];
        }
        //判断当前用户是否有头像
        $res_avatar = mysqli_query($db_connect, $avatar_sql);
        foreach ($res_avatar as $item) {
            $avatar = $item['avatar'];
        }
        if($avatar == ''){
            if($usertype == '学生'){
                mysqli_query($db_connect, "update student set avatar='$logo' where cardNo='$account'");
            }else if($usertype == '教师'){
                mysqli_query($db_connect, "update teacher set avatar='$logo' where cardNo='$account'");
            }else if($usertype == '图书管理员'){
                mysqli_query($db_connect, "update lib_worker set avatar='$logo' where id='$account'");
            }else if($usertype == '超级管理员'){
                mysqli_query($db_connect, "update super_admin set avatar='$logo' where id='$account'");
            }else{
                mysqli_query($db_connect, "update other_user set avatar='$logo' where id='$account'");
            }
            //头像为空
            $_SESSION['avatar'] = $logo; //把头像存入session
        }else{
            $_SESSION['avatar'] = $avatar; //把头像存入session
        }

        $today = strtotime(date('Y-m-d'));  //一天中的零时零分零妙
        if(strtotime($lasttime) < $today){
            // echo '小于当天，发送登录信息';  //一天只在第一次登录时发送消息
            //归属地(运营商)
            $address = getip($realip);
            // var_dump($address);
            $sender = "登录提醒";  //消息类型  发送者
            $content = "Hi！".$username."，您于".$log_time."成功登录系统，登录IP：".$realip."，归属地：".$address;  //消息内容
            //登录成功添加一条系统消息
            $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$account','$sender','$content','$log_time')";
            $msg_res = mysqli_query($db_connect, $msg_sql);
            if($msg_res){
                // echo "发送消息成功！";
            }
        }

        //把session_id和登录时间存入数据表
        mysqli_query($db_connect, $set_sid);
        //登录成功设置session过期时间为3个小时
        $_SESSION['expiretime'] = time() + 10800;

        echo json_encode(array('code' => 200, 'msg' => '登录成功！'),JSON_UNESCAPED_UNICODE);
    }
