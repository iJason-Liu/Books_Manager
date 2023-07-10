<?php
    /*
     * 权限判断
     */
    // session_save_path('../session/');
    session_start();

    $db_connect = mysqli_connect('localhost', 'root', 'root') or die('数据库服务连接失败！');
    mysqli_select_db($db_connect, 'library');
    mysqli_query($db_connect,"SET NAMES 'UTF8'");

    $url = basename($_SERVER['REQUEST_URI']);  //当前访问的文件路径
    $user_id = $_SESSION['user_id']; //用户id
    $rights_sql = "select * from rights where id='$user_id'";
    $rights_res = mysqli_query($db_connect, $rights_sql);
    $item = mysqli_fetch_array($rights_res);
    // die();

    if ($url == 'worker_list'){
        if ($item['lib_worker'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'reader_list') {
        if ($item['reader_list'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'reader_kind') {
        if ($item['reader_kind'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'book_kind') {
        if ($item['book_kind'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'borrowBook') {
        if ($item['borrowBook'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'record_search') {
        if ($item['record_search'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'comment_center') {
        if ($item['comment_center'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'news_notice') {
        if ($item['news_notice'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'feedBack') {
        if ($item['feedBack'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'rights_center') {
        if ($item['rights_center'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    //Excel文件导入数据（判断当用户通过非正常途径进行导入数据时拒绝）
    if ($url == 'import_data') {
        echo "<script>alert('非法访问，请通过正规途径访问网站！');history.back();</script>";
    }