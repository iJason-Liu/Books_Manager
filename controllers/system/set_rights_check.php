<?php
    /*
     * 权限设置确认
     * @author Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include "../../classes/check_rights.php";

    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    $id = $data['id'];  //用户id
    $name = $data['user_name']; //用户名
    //获取复选框的值 1选中 0未选中
    $lib_worker = $data['lib_worker']==''?'0':'1';   //馆员档案
    $reader_list = $data['reader_list']==''?'0':'1';  //读者档案
    $reader_kind = $data['reader_kind']==''?'0':'1';  //读者类型
    $book_kind = $data['book_kind']==''?'0':'1';  //图书类型
    $book_manager = $data['book_manager']==''?'0':'1';  //图书管理（添加，删除，更新）
    $borrowBook = $data['borrowBook']==''?'0':'1';  //图书借阅
    $record_search = $data['record_search']==''?'0':'1';  //借阅记录查询
    $comment_center = $data['comment_center']==''?'0':'1';  //评论中心审批
    $news_notice = $data['news_notice']==''?'0':'1';  //新闻公告发布
    $feedBack = $data['feedBack']==''?'0':'1';   //用户反馈查询
    $rights_center = $data['rights_center']==''?'0':'1';  //权限设置
    // print_r($data);die();

    if($item['rights_center'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        $set_sql = "update rights set lib_worker='$lib_worker',reader_list='$reader_list',reader_kind='$reader_kind',book_manager='$book_manager',book_kind='$book_kind',"
            . "borrowBook='$borrowBook',record_search='$record_search',comment_center='$comment_center',news_notice='$news_notice',"
            . "feedBack='$feedBack',rights_center='$rights_center' where id='$id'";
        // echo $set_sql;
        $res = mysqli_query($db_connect, $set_sql);
        if ($res) {
            //定义返回的数据
            $res = array(
                'code' => 200,
                'msg' => "权限设置成功，将会立即生效！"
            );
            //输出结果
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('code' => 0, 'msg' => '权限设置未生效！'), JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect);
