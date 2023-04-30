<?php
    /*
     * 手动添加图书分类
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
    foreach ($data as $items){
        $name = $items['name'];
        $desc = $items['desc'];
    }
    // print_r($data);die();

    if($item['book_kind'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        $sql1 = "insert into book_kind(type_name,mark) values ('$name','$desc')";
        $result = mysqli_query($db_connect, $sql1);
        //判断是否执行成功
        if($result){
            echo json_encode(array('code' => 200, 'msg' => '添加成功！'),JSON_UNESCAPED_UNICODE);  //删除成功
        }else{
            echo json_encode(array('code' => 0, 'msg' => '添加失败！'),JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源