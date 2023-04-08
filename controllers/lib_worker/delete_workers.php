<?php
    /*
     * 批量删除馆员
     *  @Jason Liu
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
//    print_r($data);die();

    if($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师'){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else{
        //遍历删除操作
        foreach($data as $key) {

            $sql1 = "delete from lib_worker where id='$key'";
            $result = mysqli_query($db_connect, $sql1);
        }
        //判断是否执行成功
        if($result){
            echo json_encode(array('code' => 200, 'msg' => '删除成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 0, 'msg' => '删除失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源