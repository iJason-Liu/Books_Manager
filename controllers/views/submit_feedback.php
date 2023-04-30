<?php
    /*
     * 用户提交意见或建议
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json, true);
    $name = $_SESSION['user'];   //用户名
    $user_id = $_SESSION['user_id'];  //用户id
    $sub_time = date('Y:m:d H:i:s', time());  //提交时间
    $desc = $data['desc'];  //反馈内容
    // print_r($data);die();

    $sql1 = "insert into feedback(user_id,user_name,content,sub_time) values ('$user_id','$name','$desc','$sub_time')";
    $result = mysqli_query($db_connect, $sql1);
    //判断是否执行成功
    if ($result) {
        echo json_encode(array('code' => 200, 'msg' => '提交成功，感谢您提出的宝贵意见！'), JSON_UNESCAPED_UNICODE);  //删除成功
    } else {
        echo json_encode(array('code' => 0, 'msg' => 'error！'), JSON_UNESCAPED_UNICODE);
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源