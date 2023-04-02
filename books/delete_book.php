<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../login/login.php'</script>";
    }
    /*
     * 图书删除确认页面（单条操作）
     */
    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");
    $json = file_get_contents('php://input');
    $id = json_decode($json,true);

    $sql1 = "delete from book_list where book_id='$id'";

    //同时删除对应的图书封面和图书源文件
    $sql2 = "select book_cover,status from book_list where book_id='$id'";
    $res = mysqli_query($db_connect,$sql2);
    while($row = mysqli_fetch_array($res)){
        $status = $row['status']; //判断图书的状态
        if($row['book_cover'] == ''){
            $coverPath = $row['book_cover'];  //封面路径
            break;
        }
    }
    echo $coverPath;
    //成功重定向页面
    if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
    }else if($status == 1) {
        echo json_encode(array('code' => 402, 'msg' => '您所选择的图书已借出，暂无法删除！'),JSON_UNESCAPED_UNICODE);
    }else{
        $result = mysqli_query($db_connect,$sql1);
        // $row = mysqli_affected_rows($result);  //删除操作影响的行数
        if($result){
            if($coverPath != ''){
                unlink($coverPath); //删除封面文件
            }
            echo json_encode(array('code' => 200, 'msg' => '删除成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 401, 'msg' => '删除失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源