<?php
    /*
     * 馆员档案中的馆员信息更新
     * @author Jason Liu
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
    $data = json_decode($json,true);
//    print_r($data);die();
    $id = $data['id'];
    $name = $data['name'];
    $pwd = md5($data['pwd']);
    $sex = $data['sex'];
    $mobile = $data['mobile'];
    $limit = $data['limit'];
    $updatetime = date('Y-m-d H:i:s', time());

    $sql = "update lib_worker set name='$name',password='$pwd',sex='$sex',mobile='$mobile',borrow_limit='$limit',updatetime='$updatetime' where id='$id'";
    $res = mysqli_query($db_connect,$sql);
//    echo mysqli_error($db_connect);
    if($res){
        echo json_encode(array('code' => 200, 'msg' => '恭喜您，修改成功！'),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => '修改失败！'),JSON_UNESCAPED_UNICODE);
    }
