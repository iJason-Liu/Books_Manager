<?php
    /*
     * 用户注册
     * 注册成功即登录成功！
     *
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
    $name = $data['name'];  //姓名
    $mobile = $data['mobile'];  //联系电话
    $password = md5($data['password']);  //密码
    $sex = $data['sex'];  //性别
    $usertype = $data['usertype'];  //用户类型
    $yzm = $data['yzm'];  //验证码
    $time = date('Y-m-d H:i:s', time());  //注册时间
    // var_dump($data);die();

    //把session_id存入本地session中
    $session_id = session_id();
    $_SESSION['session_id'] = $session_id;
    $log_carrier = getip($realip);  //获取登录运营商  $realip是登录ip地址

    //根据usertype类型判断插入哪一个数据表
    if($usertype == '学生'){
        $sql1 = "insert into student(name,password,sex,department,class,mobile,createtime) values ('$name','$password','$sex','未设置','未设置','$mobile','$time')";
    }else if($usertype == '教师'){
        $sql1 = "insert into teacher(name,password,sex,department,class,mobile,createtime) values ('$name','$password','$sex','未设置','未设置','$mobile','$time')";
    }else{
        $sql1 = "insert into other_user(name,password,sex,mobile,user_type,createtime) values ('$name','$password','$sex','$mobile','$usertype','$time')";
    }
    $result = mysqli_query($db_connect, $sql1);

    if($yzm != $_SESSION['check_yzm']){
        echo json_encode(array('code' => 403, 'msg' => '验证码错误！'),JSON_UNESCAPED_UNICODE);
        exit();
    }

    if($result){
        $id = mysqli_insert_id($db_connect); //注册生成的自增id
        $_SESSION['is_login'] = 2; //登录状态
        $_SESSION['usertype'] = $usertype; //登录用户身份
        $_SESSION['user'] = $name;  //登录用户名name
        $_SESSION['user_id'] = $id;  //用户id，借阅卡号

        //取随机头像存入对应注册用户数据库
        $res_logo = mysqli_query($db_connect, 'select * from avatar order by rand() limit 1');
        while ($k = mysqli_fetch_array($res_logo)){
            $logo = $k['path'];
        }
        if($usertype == '学生'){
            mysqli_query($db_connect, "update student set avatar='$logo' where cardNo='$id'");
            $set_sid = "update student set session_id='$session_id',log_time='$time',log_ip='$realip',log_carrier='$log_carrier' where cardNo='$id'";
        }else if($usertype == '教师'){
            mysqli_query($db_connect, "update teacher set avatar='$logo' where cardNo='$id'");
            $set_sid = "update teacher set session_id='$session_id',log_time='$time',log_ip='$realip',log_carrier='$log_carrier' where cardNo='$id'";
        }else{
            mysqli_query($db_connect, "update other_user set avatar='$logo' where id='$id'");
            $set_sid = "update other_user set session_id='$session_id',log_time='$time',log_ip='$realip',log_carrier='$log_carrier' where id='$id'";
        }
        //头像为空
        $_SESSION['avatar'] = $logo; //把头像存入session

        //把session_id和登录时间存入数据表
        mysqli_query($db_connect, $set_sid);

        $sender = "用户注册";  //消息类型  发送者
        $content = "Hi！".$name."，恭喜您于".$time."成功注册本系统！您的账号为".$id."，请前往个人中心完善信息！";  //消息内容
        //登录成功添加一条系统消息
        $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$id','$sender','$content','$time')";
        $msg_res = mysqli_query($db_connect, $msg_sql);

        //把注册成功的用户加入到权限表
        mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
            ." values ('$id','$name','$usertype','0','0','0','0','0','1','0','0','0','0','0')");

        //登录成功设置session过期时间为3个小时
        $_SESSION['expiretime'] = time() + 10800;

        echo json_encode(array('code' => 200, 'msg' => '注册成功，即将进入系统......'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 403, 'msg' => '注册失败，请稍后再试！'),JSON_UNESCAPED_UNICODE);
    }

