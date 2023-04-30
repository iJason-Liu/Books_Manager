<?php
    /*
     *  手动添加读者
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
    $name = $data['name'];  //姓名
    $pwd = md5($data['pwd']);  //密码
    $sex = $data['sex'];  //性别
    $department = $data['department'];  //学院
    $class = $data['class'];  //班级
    $user_type = $data['user_type'];  //身份
    $mobile = $data['mobile'];  //电话
    $createtime = date('Y-m-d H:i:s', time());  // 创建时间
    // print_r($data);die();

    if($item['reader_list'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else{
        if($user_type == '学生'){
            $sql1 = "insert into student(name,password,sex,department,class,mobile,createtime) values ('$name','$pwd','$sex','$department','$class','$mobile','$createtime')";
        }else if($user_type == '教师'){
            $sql1 = "insert into teacher(name,password,sex,department,class,mobile,createtime) values ('$name','$pwd','$sex','$department','$class','$mobile','$createtime')";
        }else{
            $sql1 = "insert into other_user(name,password,sex,mobile,user_type,createtime) values ('$name','$pwd','$sex','$mobile','$user_type','$createtime')";
        }
        $result = mysqli_query($db_connect, $sql1);
        // echo mysqli_error($db_connect);
        //判断是否执行成功
        if($result){
            $id = mysqli_insert_id($db_connect);  //获取刚刚插入数据的自增id
            //把用户加入到权限表
            mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                ." values ('$id','$name','$user_type','0','0','0','0','0','1','0','0','0','0','0')");

            echo json_encode(array('code' => 200, 'msg' => '添加成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 0, 'msg' => '添加失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源