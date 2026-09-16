<?php
    /*
     * 权限判断
     */
    require_once __DIR__ . '/session_helper.php';
    session_safe_start();

    if (!isset($db_connect)) {
        include dirname(__DIR__) . '/config/conn.php';
        $db_connect = get_db_connect();
    }

    $url = basename($_SERVER['REQUEST_URI']);  //当前访问的文件路径
    $url = strtok($url, '?');
    $user_id = session_value('user_id');
    $item = array();
    if ($user_id !== '') {
        $rights_sql = "select * from rights where id='$user_id'";
        $rights_res = mysqli_query($db_connect, $rights_sql);
        if ($rights_res) {
            $rights_row = mysqli_fetch_array($rights_res);
            if (is_array($rights_row)) {
                $item = $rights_row;
            }
        }
    }

    if ($url == 'worker_list'){
        if (!isset($item['lib_worker']) || $item['lib_worker'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'reader_list') {
        if (!isset($item['reader_list']) || $item['reader_list'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'reader_kind') {
        if (!isset($item['reader_kind']) || $item['reader_kind'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'book_kind') {
        if (!isset($item['book_kind']) || $item['book_kind'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'borrowBook') {
        if (!isset($item['borrowBook']) || $item['borrowBook'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'record_search') {
        if (!isset($item['record_search']) || $item['record_search'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'comment_center') {
        if (!isset($item['comment_center']) || $item['comment_center'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'news_notice') {
        if (!isset($item['news_notice']) || $item['news_notice'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'feedBack') {
        if (!isset($item['feedBack']) || $item['feedBack'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    if ($url == 'rights_center') {
        if (!isset($item['rights_center']) || $item['rights_center'] == 0) {
            echo "<script>alert('sorry，您暂无权限访问！');history.back();</script>";
        }
    }

    //Excel文件导入数据（判断当用户通过非正常途径进行导入数据时拒绝）
    if ($url == 'import_data') {
        echo "<script>alert('非法访问，请通过正规途径访问网站！');history.back();</script>";
    }
