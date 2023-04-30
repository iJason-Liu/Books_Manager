<?php
    /*
     * 续借快速操作
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
    $back_date = $data['back_date'];  //原应还日期
    $left_date = $data['left_day'];  //原剩余还书天数
    $renewDay = $data['newDay'];  //续借期限
    $renew_num = $data['renew_num'] + 1;  //续借次数，每次叠加1
    $renew_date = date('Y-m-d', time());  //续借日期
    $renew_Backdate = date('Y-m-d', strtotime($back_date.'+'.$renewDay.'day'));  //在应还日期上增加续借天数 续借后还书日期
    $leftDay = $left_date + $renewDay;  //剩余借书期限 原本剩余的天数+读者选择后的天数

    //更新数据
    $sql1 = "update book_borrow set left_day='$leftDay',renew_date='$renew_date',renew_backDate='$renew_Backdate',renew_num='$renew_num' where card_id = '$card_id' and book_id = '$book_id'";
    $result = mysqli_query($db_connect, $sql1);

    $createtime = date('Y-m-d H:i:s', time());
    $sender = '图书续借通知';
    $content = $user.'，您借阅的《'.$book_name.'》已续借成功，续借期限'.$renewDay.'天，请前往图书续借板块查看！';
    $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$card_id','$sender','$content','$createtime')";
    if($result){
        // 续借成功发送通知信息
        mysqli_query($db_connect, $msg_sql);
        //定义返回的数据
        $res = array('code' => 200, 'msg' => "图书续借成功，下次还书日期".$renew_Backdate."！");
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '续借失败！'),JSON_UNESCAPED_UNICODE);
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源