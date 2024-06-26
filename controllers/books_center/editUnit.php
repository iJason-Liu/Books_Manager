<?php
    /*
     * 单元格编辑事件的方法
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include "../../classes/check_rights.php";

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    //既可以是图书id，也可以是图书分类id
    $id = $_POST['id'];
    $mark = $_POST['mark'];   //图书的简介
    $type_name = $_POST['type_name'];  //图书分类名称
    $desc = $_POST['desc'];  //图书分类名称的备注
    $field = $_POST['field'];  //字段名
    $type = $_POST['type'];   //判断提交的类别，0图书  1图书分类

    if ($type == 0){
        //更新对应id的图书简介
        $sql1 = "update book_list set mark='$mark' where book_id='$id'";
        //判断当用户没有图书管理权限时不允许编辑
        if($item['book_manager'] == 0){
            echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
        }else{
            $result = mysqli_query($db_connect,$sql1);
            if($result){
                echo json_encode(array('code' => 200, 'msg' => '修改成功'),JSON_UNESCAPED_UNICODE);  //编辑成功
            }else{
                echo json_encode(array('code' => 0, 'msg' => '修改失败'),JSON_UNESCAPED_UNICODE);  //编辑失败
            }
        }
    }else if($type == 1){
        //更新对应id的图书分类名称或备注
        if($field == 'type_name'){
            $sql1 = "update book_kind set type_name='$type_name' where type_id='$id'";
        }else if($field == 'mark'){
            //更新备注
            $sql1 = "update book_kind set mark='$desc' where type_id='$id'";
        }
        //判断当用户没有图书类型权限时不允许编辑
        if($item['book_kind'] == 0){
            echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
        }else{
            $result = mysqli_query($db_connect,$sql1);
            if($result){
                echo json_encode(array('code' => 200, 'msg' => '修改成功'),JSON_UNESCAPED_UNICODE);  //编辑成功
            }else{
                echo json_encode(array('code' => 0, 'msg' => '修改失败'),JSON_UNESCAPED_UNICODE);  //编辑失败
            }
        }
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源


