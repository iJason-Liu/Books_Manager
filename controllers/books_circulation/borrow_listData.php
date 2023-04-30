<?php
    /*
     * 获取读者借阅图书列表
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $user_id = $_SESSION['user_id'];
    $user = $_SESSION['user'];

    //查询所有数据
    $sql1 = "select * from book_borrow where card_id = '$user_id' order by borrow_date desc";
    $result = mysqli_query($db_connect, $sql1);

    //查询未归还的记录条数
    $borrow_sql = "select * from book_borrow where card_id = '$user_id' and is_back='0'";
    $result1 = mysqli_query($db_connect, $borrow_sql);

    if($result){
        //定义返回的数据
        $res = array(
            'code' => 200,
            'msg' => "success",
            'count' => mysqli_num_rows($result1),
            'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC)
        );
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => 'failure！'),JSON_UNESCAPED_UNICODE);
    }

    //更新每本书的信息
    foreach ($result as $item) {
        $borrow_date = $item['borrow_date'];  //借书日期
        $back_date = $item['back_date'];  //还书日期
        $renew_backDate = $item['renew_backDate'];  //续借后还书日期
        $book_id = $item['book_id'];
        $is_back = $item['is_back'];  //是否归还
        $book_name = $item['book_name'];
        $today = date('Y-m-d', time());
        //如果续借应还日期大于原应还日期，使用续借后的日期判断剩余天数
        if($renew_backDate > $back_date){
            $diff = strtotime($renew_backDate) - strtotime($today);
            $leftDay = round($diff / 86400);  //剩余天数
            // abs(）取绝对值则不会为负数
        }else{
            $diff = strtotime($back_date) - strtotime($today);
            $leftDay = round($diff / 86400);  //剩余天数
        }

        //判断当还书剩余天数大于0 并且 未归还   更新剩余天数
        if($leftDay > 0 && $is_back == 0){
            if($book_id && $back_date > $today || $renew_backDate > $today){
                $sql = "update book_borrow set left_day='$leftDay' where card_id='$user_id' and book_id='$book_id'";
                mysqli_query($db_connect, $sql);
            }
        }

        // 当离还书日期还有3天时发送通知信息
        $createtime = date('Y-m-d H:i:s', time());
        $sender = '借阅到期提醒';
        $content = $user.'，您于'.$borrow_date.'借阅的图书《'.$book_name.'》还有3天期限，请在'.$back_date.'前归还或完成续借操作，逾期将受到惩罚！';
        //避免重复发送
        $i = mysqli_num_rows(mysqli_query($db_connect, "select * from sys_msg where content='$content'"));
        if($i == 0){  //查询返回条数，等于0没查到 就发送消息，1则不发送
            //发送即将到期提醒
            if($book_id && $leftDay == 3){
                $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$user_id','$sender','$content','$createtime')";
                mysqli_query($db_connect, $msg_sql);
            }
        }

        $yz_sql = "select * from book_borrow where card_id='$user_id' and book_id='$book_id' and is_back='0'";
        $yz_res = mysqli_query($db_connect, $yz_sql);
        $flag = mysqli_num_rows($yz_res);  //判断是否查到图书未归还的条数 1查到 0未查到
        $sender1 = '图书逾期提醒';
        $content1 = $user.'，您于'.$borrow_date.'借阅的图书《'.$book_name.'》已经逾期，您的借阅卡已被暂停使用，请及时处理（您可以归还图书或联系管理员处理）！';
        //避免重复发送
        $j = mysqli_num_rows(mysqli_query($db_connect, "select * from sys_msg where content='$content1'"));
        if($j == 0){  //查询返回条数，等于0就发送消息，1则不发送
            //发送逾期信息
            if($flag == 1 && $leftDay < 0){
                $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$user_id','$sender1','$content1','$createtime')";

                //更新逾期读者的借阅卡状态
                $usertype = $_SESSION['usertype']; //用户登录时的身份
                if($usertype == '学生'){
                    $yuqi_sql = "update student set card_status='1' where cardNo = '$user_id'";
                }else if($usertype == '教师'){
                    $yuqi_sql = "update teacher set card_status='1' where cardNo = '$user_id'";
                }else if($usertype == '图书管理员'){
                    $yuqi_sql = "update lib_worker set card_status='1' where id = '$user_id'";
                }else if($usertype == '超级管理员'){
                    $yuqi_sql = "update super_admin set card_status='1' where id = '$user_id'";
                }else{
                    $reset_sql = "update other_user set card_status='1' where id = '$user_id'";
                }
                mysqli_query($db_connect, $msg_sql);
                mysqli_query($db_connect, $yuqi_sql);
                mysqli_query($db_connect, "update book_borrow set mark='已逾期' where card_id='$user_id' and book_id='$book_id'");  //未归还图书更新备注
            }
        }
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源