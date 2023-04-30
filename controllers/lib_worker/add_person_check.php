<?php
    /*
     * 手动添加馆员
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
    $name = $data['name'];
    $pwd = md5($data['pwd']);
    $sex = $data['sex'];
    $mobile = $data['mobile'];
    $createtime = date('Y-m-d H:i:s', time());
    $user_type = $_SESSION['usertype'];
    // print_r($data);die();

    if($item['lib_worker'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else{
        $sql1 = "insert into lib_worker(name,password,sex,mobile,createtime) values ('$name','$pwd','$sex','$mobile','$createtime')";
        $result = mysqli_query($db_connect, $sql1);
        //判断是否执行成功
        if($result){
            $id = mysqli_insert_id($db_connect);  //获取刚刚插入数据的自增id
            //把用户加入到权限表
            mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                ." values ('$id','$name','$user_type','0','1','1','1','1','1','1','1','1','1','0')");

            echo json_encode(array('code' => 200, 'msg' => '添加成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 0, 'msg' => '添加失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源