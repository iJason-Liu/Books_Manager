<?php
    /*
     * 批量删除馆员
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
    // print_r($data);die();

    if($item['lib_worker'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        //遍历删除操作
        foreach ($data as $key) {
            $sql1 = "delete from lib_worker where id='$key';delete from rights where id='$key'";

            $check_sql = "select * from book_borrow where card_id = '$key' and is_back = '0'";
            $flag = mysqli_num_rows(mysqli_query($db_connect, $check_sql));
            //存在未归还的图书，不允许删除，跳过
            if($flag == 1){
                continue;
            }else{
                $result = mysqli_query($db_connect, $sql1);
            }
        }
        //判断是否执行成功
        if ($result) {
            echo json_encode(array('code' => 200, 'msg' => '删除成功！'), JSON_UNESCAPED_UNICODE);  //删除成功
        } else {
            echo json_encode(array('code' => 0, 'msg' => '删除失败，选择的用户中包含未归还图书的用户！'), JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源