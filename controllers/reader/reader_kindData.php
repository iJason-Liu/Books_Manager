<?php
    /*
     * 获取所有读者类别数据
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    // 阻止非登录用户和登录用户身份不符 进行操作
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    //查询所有数据
    $sql1 = "select * from user_type order by type_id";
    $result = mysqli_query($db_connect, $sql1);

    if($result){
        //定义返回的数据头
        $res = array('code' => 200,'msg' => "success",'data'=> mysqli_fetch_all($result,MYSQLI_ASSOC));
        //输出结果
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 0, 'msg' => 'failure！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect); //关闭数据库资源