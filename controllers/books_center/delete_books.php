<?php
    /*
     * 批量删除图书
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
    $data = json_decode($json,true);
   // print_r($data);die();

    foreach($data as $key) {
        if($key['status'] == 1){
            $status = $key['status']; //图书状态
            break;
        }
    }

    if($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师'){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else if($status == 1){
        echo json_encode(array('code' => 402, 'msg' => '您选择的图书包含借出图书，暂无法删除！'),JSON_UNESCAPED_UNICODE);
    }else{
        //遍历删除操作
        foreach($data as $key) {
            $id = $key['book_id']; //图书id

            $sql1 = "delete from book_list where book_id='$id'";
            //同时删除对应的图书封面和图书源文件
            $sql2 = "select book_cover from book_list where book_id='$id'";
            $res = mysqli_query($db_connect, $sql2);
            while ($row = mysqli_fetch_array($res)) {
                if($row['book_cover'] == ''){
                    $coverPath = $row['book_cover'];  //封面路径
                    break;
                }
            }

            $result = mysqli_query($db_connect, $sql1);
//          $rows = mysqli_affected_rows($db_connect);  //删除操作影响的行数
            if($coverPath != ''){
                unlink($coverPath); //删除封面文件
            }
        }
        //判断是否执行成功
        if($result){
            echo json_encode(array('code' => 200, 'msg' => '删除成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 401, 'msg' => '删除失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源