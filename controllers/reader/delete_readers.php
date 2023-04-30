<?php
    /*
     * 批量删除读者
     *  @Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include "../../classes/check_rights.php";

    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $json = file_get_contents('php://input');
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);
    // print_r($data);die();

    if($item['reader_list'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else{
        //遍历删除操作
        foreach($data as $key) {
            $cardNo = $key['cardNo']; //读者id
            // echo $id = $key['id']; //读者id
            $user_type = $key['user_type']; //读者类型

            $sql1 = "delete from student where cardNo='$cardNo' and user_type='学生'";
            // $result = mysqli_query($db_connect, $sql1);

            $sql2 = "delete from teacher where cardNo='$cardNo' and user_type='教师'";
            // $result2 = mysqli_query($db_connect, $sql2);

            $sql3 = "delete from other_user where id='$cardNo'";
            // $result3 = mysqli_query($db_connect, $sql3);

            //删除对应权限表中的数据
            $del_rights = "delete from rights where id='$cardNo'";
            // $result4 = mysqli_query($db_connect, $del_rights);

            $check_sql = "select * from book_borrow where card_id='$cardNo' and is_back = '0'";
            $flag = mysqli_num_rows(mysqli_query($db_connect, $check_sql));
            //存在未归还的图书，不允许删除，跳过
            if($flag == 1){
                continue;
            }else{
                $result = mysqli_query($db_connect, $sql1);
                $result2 = mysqli_query($db_connect, $sql2);
                $result3 = mysqli_query($db_connect, $sql3);
                $result4 = mysqli_query($db_connect, $del_rights);
            }
        }
        //判断是否执行成功
        if($result || $result2 || $result3 || $result4){
            echo json_encode(array('code' => 200, 'msg' => '删除成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 0, 'msg' => '删除失败，选择的读者中包含未归还图书的读者！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源