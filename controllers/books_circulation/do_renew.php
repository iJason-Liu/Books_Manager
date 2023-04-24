<?php
    /*
     * 自主续借， 选择日期
     *
     * 后期需要可开启自主选择当天以后的日期，起止自定
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);

    $user = $_SESSION['user'];
    $card_id = $data['card_id'];  //读者id  借阅卡号
    $book_id = $data['book_id'];  //图书id
    $book_name = $data['book_name'];  //图书名称
    $left_date = $data['left_day'];  //原剩余还书天数
    $renewDay = $data['renewDay'];  // 续借天数
    $renew_num = $data['renew_num'] + 1;  //续借次数，每次叠加1
    $today = $data['startDate'];  //续借开始日期
    $renew_Backdate = $data['endDate']; //续借截止期限 2023-04-20 格式
    $leftDay = $left_date + $renewDay;  //剩余借书期限 原本剩余的天数+读者选择后的天数

    //更新数据
    $sql1 = "update book_borrow set left_day='$leftDay',renew_date='$today',renew_backDate='$renew_Backdate',renew_num='$renew_num' where card_id = '$card_id' and book_id = '$book_id'";
    $result = mysqli_query($db_connect, $sql1);

    if($result){
        //定义返回的数据
        $res = array(
            'code' => 200,
            'msg' => "图书续借成功，下次还书日期".$renew_Backdate."！"
        );
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '续借失败！'),JSON_UNESCAPED_UNICODE);
    }

    // 续借成功发送通知信息
    $createtime = date('Y-m-d H:i:s', time());
    $sender = '图书续借通知';
    $content = $user.'，您借阅的《'.$book_name.'》已续借成功，续借期限'.$renewDay.'天，请前往图书续借板块查看！';
    if($result){
        $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$card_id','$sender','$content','$createtime')";
        mysqli_query($db_connect, $msg_sql);
    }

    echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源