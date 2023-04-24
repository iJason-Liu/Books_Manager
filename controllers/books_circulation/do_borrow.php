<?php
    /*
     * 图书借阅实现方法
     *
     * 目前暂不考虑选择日期，默认借阅都是三个月
     * 后期需要再改进点击借阅选择日期间隔，一个月 三个月 六个月  判断日期范围
     */
    session_save_path('../../session/');
    session_start();
    include "../../config/conn.php";

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $book_data = json_decode($json,true);
    $book_id = $book_data['book_id'];
    $book_name = $book_data['book_name'];
    $book_price = $book_data['price'];
    $status = $book_data['status'];  //图书状态
    $num = $book_data['number'];  //图书库存
    $borrow_num = $book_data['borrow_num'];  //图书借阅次数

    $user_id = $_SESSION['user_id'];  //读者id  借阅卡号
    $user = $_SESSION['user'];  //读者用户名
    $borrow_date = date('Y-m-d', time());  //借书日期
    $limit = 90; //借书期限90天
    $return_date = date('Y-m-d', strtotime('+'.$limit.'day'));  //还书日期， 90天后

    //判断读者是否借阅过所选图书
    $yz_sql = mysqli_num_rows(mysqli_query($db_connect, "select * from book_borrow where card_id='$user_id' and book_id='$book_id'"));

    //插入借书记录
    if($status == 1){
        echo json_encode(array('code' => 0, 'msg' => '该图书已被借出，请选择其他图书！'),JSON_UNESCAPED_UNICODE);
    }else if($num == 0){
        echo json_encode(array('code' => 0, 'msg' => '该图书当前没有库存了，请留意后续更新！'),JSON_UNESCAPED_UNICODE);
    }else if($yz_sql == 1){
        echo json_encode(array('code' => 0, 'msg' => '抱歉，因目前业务需要，一本图书一位读者只允许借阅一次！'),JSON_UNESCAPED_UNICODE);
    }else{
        $insert_sql = "insert into book_borrow(card_id,book_id,book_name,book_price,borrow_limitDay,left_day,borrow_date,back_date) values ('$user_id','$book_id','$book_name','$book_price','$limit','$limit','$borrow_date','$return_date')";
        $insert_res = mysqli_query($db_connect, $insert_sql);
    }

    $usertype = $_SESSION['usertype']; //用户登录时的身份
    if($usertype == '学生'){
        $user_sql = "select * from student where cardNo = '$user_id'";
    }else if($usertype == '教师'){
        $user_sql = "select * from teacher where cardNo = '$user_id'";
    }else if($usertype == '图书管理员'){
        $user_sql = "select * from lib_worker where id = '$user_id'";
    }else if($usertype == '超级管理员'){
        $user_sql = "select * from super_admin where id = '$user_id'";
    }
    $user_res = mysqli_query($db_connect, $user_sql);
    // foreach ($user_res as $item) {
    //     $borrow_limit = $item['borrow_limit'];  //读者图书借阅数量
    // }

    // $left_borrowLimit = $borrow_limit - 1; //剩余借书数量
    // if($borrow_limit != 0 && $insert_res){
    //     if($usertype == '学生'){
    //         $update_userSql = "update student set borrow_limit='$left_borrowLimit' where cardNo = '$user_id'";
    //     }else if($usertype == '教师'){
    //         $update_userSql = "update teacher set borrow_limit='$left_borrowLimit' where cardNo = '$user_id'";
    //     }else if($usertype == '图书管理员'){
    //         $update_userSql = "update lib_worker set borrow_limit='$left_borrowLimit' where id = '$user_id'";
    //     }else if($usertype == '超级管理员'){
    //         $update_userSql = "update super_admin set borrow_limit='$left_borrowLimit' where id = '$user_id'";
    //     }
    //     mysqli_query($db_connect, $update_userSql);
    // }

    $left_num = $num - 1;
    $new_borrowNum = $borrow_num + 1;
    //更新图书列表信息
    if($num != 0 && $insert_res){
        $update_sql = "update book_list set number='$left_num', status='1', borrow_num='$new_borrowNum' where book_id = '$book_id'";
        mysqli_query($db_connect, $update_sql);
    }

    $createtime = date('Y-m-d H:i:s', time());
    $sender = '图书借阅通知';
    $content = $user.'，恭喜您于'.$createtime.'成功借阅《'.$book_name.'》，借阅期限'.$limit.'天，请在'.$return_date.'前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！';
    //发送信息
    if($insert_res){
        $msg_sql = "insert into sys_msg(user_id,sender,content,createtime) values ('$user_id','$sender','$content','$createtime')";
        mysqli_query($db_connect, $msg_sql);
        echo json_encode(array('code' => 200, 'msg' => '图书借阅成功！'),JSON_UNESCAPED_UNICODE);
    }

    echo mysqli_error($db_connect);  //输出sql执行错误信息

    mysqli_close($db_connect);  //关闭资源
