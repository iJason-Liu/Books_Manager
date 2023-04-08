<?php
    /*
     * 单元格编辑事件的方法
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo "<script>alert('sorry，您暂无权限操作！');history.back();</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    //既可以是图书id，也可以是图书分类id
    $id = $_POST['id'];
    $mark = $_POST['mark'];   //图书的简介
    $type_name = $_POST['type_name'];  //图书分类名称
    $desc = $_POST['desc'];  //图书分类名称的备注
    $field = $_POST['field'];  //字段名
    $type = $_POST['type'];   //判断提交的类别，0 图书  1 图书分类

    if ($type == 0){
        //更新对应id的图书简介
        $sql1="update book_list set mark='$mark' where book_id='$id'";
    }else if($type == 1){
        //更新对应id的图书分类名称或备注
        if($field == 'type_name'){
            $sql1="update book_kind set type_name='$type_name' where type_id='$id'";
        }else if($field == 'mark'){
            //无法执行！！！
            $sql1="update book_kind set mark='$desc' where type_id='$id'";
        }
    }

    $result=mysqli_query($db_connect,$sql1);
    echo mysqli_error($db_connect);
    if($result){
        echo json_encode(array('code' => 200, 'msg' => 'ok'),JSON_UNESCAPED_UNICODE);  //编辑成功
    }else{
        echo json_encode(array('code' => 0, 'msg' => 'failure'),JSON_UNESCAPED_UNICODE);  //编辑失败
    }

    mysqli_close($db_connect); //关闭数据库资源


