<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    /*
     * 图书删除确认页面（批量操作）
     */
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $arr = $_POST['dataArr'];
    // var_dump($arr);

    //遍历删除操作
    foreach($arr as $key) {
        $id = $key['book_id']; //id
//        $status = $key['status']; //状态

        $sql1 = "delete from book_list where book_id='$id' and status='0'";

         //同时删除对应的图书封面和图书源文件
        $sql2 = "select book_cover,status from book_list where book_id='$id'";
        $res = mysqli_query($db_connect,$sql2);
        while($row = mysqli_fetch_array($res)){
            $coverPath = $row['book_cover']; //封面路径
            $status = $row['status'];  //图书状态
        }
        //成功重定向页面
        if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
            echo 403;
//            echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);; //无权限
        }else{
            $result = mysqli_query($db_connect,$sql1);
//            $rows = mysqli_num_rows($result);  //删除操作影响的行数
        }
    }
    if($status == 1){
        echo 402;
    }
    if($result){
        if($coverPath != ''){
            unlink($coverPath); //删除封面文件
        }
        echo 200;
    //                echo json_encode(array('code' => 200, 'msg' => '成功删除了'.$rows.'本图书！'),JSON_UNESCAPED_UNICODE);;  //删除成功
    }

    mysqli_close($db_connect); //关闭数据库资源