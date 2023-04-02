<?php
    /*
     * 手动添加读者
     *  @Jason Liu
     */
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);
    $name = $data['name'];
    $pwd = md5($data['pwd']);
    $sex = $data['sex'];
    $department = $data['department'];
    $class = $data['class'];
    $user_type = $data['user_type'];
    $mobile = $data['mobile'];
    $createtime = date('Y-m-d H:i:s', time());
//    print_r($data);die();

    if($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师'){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else{
        if($user_type == '学生'){
            $sql1 = "insert into student(name,password,sex,department,class,mobile,createtime) values ('$name','$pwd','$sex','$department','$class','$mobile','$createtime')";
        }else if($user_type == '教师'){
            $sql1 = "insert into teacher(name,password,sex,department,class,mobile,createtime) values ('$name','$pwd','$sex','$department','$class','$mobile','$createtime')";
        }
        $result = mysqli_query($db_connect, $sql1);
        echo mysqli_error($db_connect);
        //判断是否执行成功
        if($result){
            echo json_encode(array('code' => 200, 'msg' => '添加成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 0, 'msg' => '添加失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源