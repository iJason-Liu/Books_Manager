<?php
    /*
     * 批量还书操作
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $book_data = json_decode($json,true);
    $user = $_SESSION['user'];
    $return_sql = "";  //还书sql
    $createtime = date('Y-m-d H:i:s', time());

    //遍历归还操作
    foreach ($book_data as $item) {
        $book_id = $item['book_id']; //图书id
        $card_id = $item['card_id']; //借阅卡号
        $is_back = $item['is_back']; //图书归还状态 0未归还  1已归还
        $book_name = $item['book_name'];  //图书名称
        $num = $item['number'];  //图书库存
        $borrow_date = $item['borrow_date'];  //图书借阅日期
        $back_date = $item['back_date'];  //还书日期
        $renew_backDate = $item['renew_backDate'];  //续借后还书日期
        $borrow_num = $item['borrow_num'];  //图书借阅次数
        $do_backDate = date('Y-m-d', time());  //操作还书的日期

        //判断是否逾期是归还
        if($renew_backDate > $back_date){
            //当续借后的应还日期大于原还书日期，说明该书被续借过，则用操作还书的日期和续借后的应还日期比较，大于则是逾期归还，小于则相反
            if($do_backDate > $renew_backDate){
                $mark = '逾期归还';
            }else{
                $mark = '非逾期归还';
            }
        }else{
            if($do_backDate > $back_date){
                $mark = '逾期归还';
            }else{
                $mark = '非逾期归还';
            }
        }

        $new_num = $num + 1;  //库存数量 还书+1
        $sender = '图书归还通知';
        $content = $user.'，您于'.$borrow_date.'借阅的图书《'.$book_name.'》已成功归还！';
        //拼接sql语句
        if($is_back == 0){  //状态未归还的图书 执行
            $return_sql .= "update book_borrow set is_back='1',left_day='0',do_backDate='$do_backDate',mark='$mark' where book_id='$book_id' and card_id='$card_id';";
            $new_sql = "update book_list set number='$new_num', status='0' where book_id = '$book_id';";
            $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$card_id','$sender','$content','$createtime');";
            $result = mysqli_multi_query($db_connect, $return_sql);
            mysqli_query($db_connect, $new_sql);
            mysqli_query($db_connect, $msg_sql);
        }
        // print_r($return_sql);
    }
    // echo mysqli_store_result($db_connect);  //查询语句才执行
    // $ok_num = mysqli_num_rows($result);  // 获取还书成功的条数
    //判断是否执行成功
    if($result){
        echo json_encode(array('code' => 200, 'msg' => '一键归还成功！'), JSON_UNESCAPED_UNICODE);  //删除成功
    }else{
        echo json_encode(array('code' => 0, 'msg' => '归还失败，所选择的图书已全部归还！'), JSON_UNESCAPED_UNICODE);
    }

    // echo mysqli_num_rows($result);  //执行成功的条数

    echo mysqli_error($db_connect);  //如果sql执行错误输出错误信息

    mysqli_close($db_connect); //关闭数据库资源