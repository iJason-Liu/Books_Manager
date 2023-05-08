<?php
    /*
     * 搜索读者的借阅记录
     * 关键词类型如下：
     * 0 借阅卡号
     * 1 图书编号
     * 3 日期范围
     */
    include '../../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $keywords = $_GET['keywords']; //关键词
    $keywords_type = $_GET['keywords_type']; //关键词类型
    $startDate = $_GET['startDate']; //开始日期
    $endDate = $_GET['endDate']; //结束日期

    //查询数据
    if ($keywords_type == 0) {
        $sql1 = "select * from book_borrow where card_id = '$keywords' order by is_back";
    } else if ($keywords_type == 1) {
        $sql1 = "select * from book_borrow where book_id = '$keywords' order by is_back";
    }else{
        $sql1 = "select * from book_borrow where borrow_date between '$startDate' and '$endDate' order by is_back";
    }
    $result_data = mysqli_query($db_connect, $sql1);

    //定义返回的数据
    $res = array(
        'code' => 200,
        'msg' => "success",
        'count' => mysqli_num_rows($result_data),
        'data' => mysqli_fetch_all($result_data, MYSQLI_ASSOC)
    );

    if($result_data){
        //更新查询到的记录中未归还的图书的剩余天数
        foreach ($result_data as $item) {
            $back_date = $item['back_date'];  //还书日期
            $renew_backDate = $item['renew_backDate'];  //续借后还书日期
            $book_id = $item['book_id'];
            $card_id = $item['card_id'];  //借阅卡号
            $is_back = $item['is_back'];  //是否归还
            $today = date('Y-m-d', time());  //当天日期
            //如果续借应还日期大于原应还日期，使用续借后的日期判断剩余天数
            if($renew_backDate > $back_date){
                $diff = strtotime($renew_backDate) - strtotime($today);
                $leftDay = round($diff / 86400);  //剩余天数 round四舍五入
            }else{
                $diff = strtotime($back_date) - strtotime($today);
                $leftDay = round($diff / 86400);  //剩余天数
            }

            //判断当还书剩余天数大于0 并且 未归还 更新剩余天数
            if($leftDay > 0 && $is_back == 0){
                if($book_id && $back_date > $today || $renew_backDate > $today){
                    $new_sql = "update book_borrow set left_day='$leftDay' where card_id='$card_id' and book_id='$book_id'";
                    mysqli_query($db_connect, $new_sql);
                }
            }

            $yz_sql = "select * from book_borrow where card_id='$card_id' and book_id='$book_id' and is_back='0'";
            $yz_res = mysqli_query($db_connect, $yz_sql);
            $flag = mysqli_num_rows($yz_res);  //判断是否查到图书未归还的条数 1查到 0未查到
            //当查到1条数据并且剩余天数小于0
            if($flag == 1 && $leftDay < 0){
                //更新逾期读者的借阅卡状态
                $usertype = $_SESSION['usertype']; //用户登录时的身份
                if($usertype == '学生'){
                    $yuqi_sql = "update student set card_status='1' where cardNo = '$card_id'";
                    $exit_user = mysqli_num_rows(mysqli_query($db_connect, "select * from student where cardNo='$card_id'"));
                }else if($usertype == '教师'){
                    $yuqi_sql = "update teacher set card_status='1' where cardNo = '$card_id'";
                    $exit_user = mysqli_num_rows(mysqli_query($db_connect, "select * from teacher where cardNo='$card_id'"));
                }else if($usertype == '图书管理员'){
                    $yuqi_sql = "update lib_worker set card_status='1' where id = '$card_id'";
                    $exit_user = mysqli_num_rows(mysqli_query($db_connect, "select * from lib_worker where id='$card_id'"));
                }else if($usertype == '超级管理员'){
                    $yuqi_sql = "update super_admin set card_status='1' where id = '$card_id'";
                    $exit_user = mysqli_num_rows(mysqli_query($db_connect, "select * from super_admin where id='$card_id'"));
                }else{
                    $reset_sql = "update other_user set card_status='1' where id = '$card_id'";
                    $exit_user = mysqli_num_rows(mysqli_query($db_connect, "select * from other_user where id='$card_id'"));
                }
                //判断当用户未注销时才更新他的借阅卡状态
                if($exit_user == 1){
                    mysqli_query($db_connect, $yuqi_sql);
                }
                mysqli_query($db_connect, "update book_borrow set mark='已逾期' where card_id='$card_id' and book_id='$book_id'");  //未归还图书更新备注
            }
        }

        //输出结果
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    // echo mysqli_error($db_connect); //sql执行错误描述

    mysqli_close($db_connect); //关闭数据库资源