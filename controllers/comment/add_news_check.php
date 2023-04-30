<?php
    /*
     *  添加文章（新闻/公告）
     *  @Jason Liu
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include "../../classes/check_rights.php";

    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");

    // $json = file_get_contents('php://input');
    $content = $_POST['content'];  //富文本 文章内容
    $cover = $_POST['cover'];  //封面
    $json = $_POST['form_data'];
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);
    // $article_cover = $data['article_cover'];  //文章封面
    $author = $data['author'];  //作者
    $title = $data['title'];  //标题
    $type = $data['type'];  //1新闻  2公告
    $sub_time = date('Y-m-d', time());  //发布时间  年月日
    // print_r($data);die();

    if($item['news_notice'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        $sql1 = "insert into news_notice(title,author,type,content,cover_img,sub_time) values ('$title','$author','$type','$content','$cover','$sub_time')";
        $result = mysqli_query($db_connect, $sql1);
        //判断是否执行成功
        if ($result) {
            echo json_encode(array('code' => 200, 'msg' => '发布成功！'), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array('code' => 0, 'msg' => '发布失败，请稍后再试！'), JSON_UNESCAPED_UNICODE);
        }
    }

    mysqli_close($db_connect); //关闭数据库资源