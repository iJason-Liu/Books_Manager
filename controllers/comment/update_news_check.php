<?php
    /*
     *  更新文章（新闻/公告）
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
    $flag = $_POST['flag'];  //提交类型  1更新  2删除
    $json = $_POST['form_data'];
    //直接放参数得到的是 object 上面的数据类型，添加了true得到的则是数组
    $data = json_decode($json,true);
    // $article_cover = $data['article_cover'];  //文章封面
    $id = $data['id'];  //新闻id
    $author = $data['author'];  //作者
    $title = $data['title'];  //标题
    $type = $data['type'];  //1新闻  2公告
    $new_sub_time = date('Y-m-d', time());  //更新的发布时间  年月日
    // print_r($data);die();

    if($item['news_notice'] == 0){
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE); //无权限
    }else {
        if ($flag == 1) {
            $sql1 = "update news_notice set title='$title',author='$author',content='$content',cover_img='$cover',type='$type',sub_time='$new_sub_time' where id='$id'";
            $result = mysqli_query($db_connect, $sql1);
            //判断是否执行成功
            if ($result) {
                echo json_encode(array('code' => 200, 'msg' => '文章更新成功！'), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array('code' => 0, 'msg' => '更新失败，请稍后再试！'), JSON_UNESCAPED_UNICODE);
            }
        } else if ($flag == 2) {
            $sql2 = "delete from news_notice where id='$id'";
            $res = mysqli_query($db_connect, $sql2);
            if ($res) {
                echo json_encode(array('code' => 200, 'msg' => '文章删除成功！'), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array('code' => 0, 'msg' => '删除失败，请稍后再试！'), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    // echo mysqli_error($db_connect);

    mysqli_close($db_connect); //关闭数据库资源