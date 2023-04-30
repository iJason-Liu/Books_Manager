<?php
    /*
     * 还书操作  指定一本
     * 更新借阅卡状态
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $book_data = json_decode($json,true);

    $book_id = $book_data['book_id']; //获取图书id
    $book_name = $book_data['book_name'];  //图书名称
    $num = $book_data['number'];  //图书库存

    $borrow_date = $book_data['borrow_date'];  //图书借阅日期
    $back_date = $book_data['back_date'];  //还书日期
    $renew_backDate = $book_data['renew_backDate'];  //续借后还书日期
    $borrow_num = $book_data['borrow_num'];  //图书借阅次数
    $do_backDate = date('Y-m-d', time());  //操作还书的日期

    $user_id = $book_data['card_id'];
    $user = $_SESSION['user'];

    //判断是否逾期归还
    if($renew_backDate > $back_date){
        //当续借后的应还日期大于原还书日期，说明该书被续借过，则用操作还书的日期和续借后的应还日期比较，大于则是逾期归还，小于则相反
        if($do_backDate > $renew_backDate){
            $mark = '逾期归还';
            //更新逾期读者的借阅卡状态
            $usertype = $_SESSION['usertype']; //用户登录时的身份
            if($usertype == '学生'){
                $reset_sql = "update student set card_status='0' where cardNo = '$user_id'";
            }else if($usertype == '教师'){
                $reset_sql = "update teacher set card_status='0' where cardNo = '$user_id'";
            }else if($usertype == '图书管理员'){
                $reset_sql = "update lib_worker set card_status='0' where id = '$user_id'";
            }else if($usertype == '超级管理员'){
                $reset_sql = "update super_admin set card_status='0' where id = '$user_id'";
            }else{
                $reset_sql = "update other_user set card_status='0' where id = '$user_id'";
            }
            //更想借阅卡状态
            mysqli_query($db_connect, $reset_sql);
        }
    }else{
        if($do_backDate > $back_date){
            $mark = '逾期归还';
            //更新逾期读者的借阅卡状态
            $usertype = $_SESSION['usertype']; //用户登录时的身份
            if($usertype == '学生'){
                $reset_sql = "update student set card_status='0' where cardNo = '$user_id'";
            }else if($usertype == '教师'){
                $reset_sql = "update teacher set card_status='0' where cardNo = '$user_id'";
            }else if($usertype == '图书管理员'){
                $reset_sql = "update lib_worker set card_status='0' where id = '$user_id'";
            }else if($usertype == '超级管理员'){
                $reset_sql = "update super_admin set card_status='0' where id = '$user_id'";
            }
            //更想借阅卡状态
            mysqli_query($db_connect, $reset_sql);
        }
    }

    //只更新不删除记录，归还sql
    $return_sql = "update book_borrow set is_back='1',left_day='0',do_backDate='$do_backDate',mark='$mark' where book_id='$book_id' and card_id='$user_id'";
    $result = mysqli_query($db_connect, $return_sql);

    $new_num = $num + 1;  //库存数量 还书+1
    $new_sql = "update book_list set number='$new_num', status='0' where book_id = '$book_id'";

    $createtime = date('Y-m-d H:i:s', time());
    $sender = '图书归还通知';
    $content = $user.'，您于'.$borrow_date.'借阅的图书《'.$book_name.'》已成功归还！';
    $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$user_id','$sender','$content','$createtime')";

    if($result){
        //更新图书数据表
        mysqli_query($db_connect, $new_sql);
        //发送信息
        mysqli_query($db_connect, $msg_sql);
        echo json_encode(array('code' => 200, 'msg' => '图书归还成功！'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '还书失败，请稍后再试！'),JSON_UNESCAPED_UNICODE);
    }

    // echo mysqli_error($db_connect);  //输出sql执行错误信息

    mysqli_close($db_connect);  //关闭资源
