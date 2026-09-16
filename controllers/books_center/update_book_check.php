<?php
    /*
     * 更新单本图书
     */
    session_save_path('../../session/');
    session_start();
    require_once __DIR__ . '/../../config/conn.php';
    $db_connect = get_db_connect();
    include __DIR__ . '/../../classes/check_rights.php';
    include __DIR__ . '/../../classes/upload_helper.php';

    header("Content-Type:text/html;charset=utf-8");

    if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] != 2) {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
        exit;
    }
    if (!isset($item['book_manager']) || $item['book_manager'] == 0) {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
        exit;
    }

    $has_new_cover = isset($_FILES['book_cover']) && $_FILES['book_cover']['error'] !== UPLOAD_ERR_NO_FILE;

    // Layui 异步上传封面（仅传文件，不含表单字段）
    if ($has_new_cover && !isset($_POST['update'])) {
        $upload_result = upload_save_image($_FILES['book_cover'], 'bookCover');
        if (!$upload_result) {
            echo json_encode(array('code' => 403, 'msg' => '封面上传失败！'),JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo json_encode(array(
            'code' => 0,
            'msg' => 'success',
            'data' => array('url' => $upload_result['filepath'])
        ),JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!isset($_POST['update'])) {
        exit;
    }

    $id = $_GET['id'] ?? '';
    $isbn = $_POST['ISBN'] ?? '';
    $name = $_POST['bookname'] ?? '';
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $price = $_POST['price'] ?? $_POST['bookprice'] ?? 0;
    $number = $_POST['number'] ?? 0;
    $type = $_POST['booktype'] ?? '';
    $place = $_POST['saveplace'] ?? '';
    $mark = $_POST['mark'] ?? '';
    $update_time = date('Y-m-d H:i:s', time());

    $coverPath = '';
    $sql_file = "select book_cover from book_list where book_id='$id'";
    $res_file = mysqli_query($db_connect,$sql_file);
    if ($row = mysqli_fetch_array($res_file)) {
        if ($row['book_cover'] != '') {
            $coverPath = $row['book_cover'];
        }
    }

    $href = '';
    if ($has_new_cover) {
        $upload_result = upload_save_image($_FILES['book_cover'], 'bookCover');
        if (!$upload_result) {
            echo "<script>alert('封面上传失败，请检查文件格式！');history.back();</script>";
            exit;
        }
        $href = $upload_result['href'];
    }

    if ($has_new_cover) {
        $sql1 = "update book_list set ISBN='$isbn',book_name='$name',author='$author',publisher='$publisher',price='$price',number='$number',book_type='$type',save_position='$place',mark='$mark',update_date='$update_time',book_cover='$href' where book_id='$id'";
        $result = mysqli_query($db_connect, $sql1);
        if ($result) {
            if ($coverPath != '' && strpos($coverPath, 'upload/bookCover/') !== false) {
                $old_cover_file = '../../' . ltrim(parse_url($coverPath, PHP_URL_PATH), '/');
                if (is_file($old_cover_file)) {
                    unlink($old_cover_file);
                }
            }
            echo "<script>alert('更新图书信息成功！');parent.location.href = '../../administrator/books_center/book_list';</script>";
        } else {
            echo "<script>alert('更新失败！请检查内容是否合法！');history.back();</script>";
        }
    } else {
        $sql2 = "update book_list set ISBN='$isbn',book_name='$name',author='$author',publisher='$publisher',price='$price',number='$number',book_type='$type',save_position='$place',mark='$mark',update_date='$update_time' where book_id='$id'";
        $result2 = mysqli_query($db_connect, $sql2);
        if ($result2) {
            echo "<script>alert('更新图书信息成功！');parent.location.href = '../../administrator/books_center/book_list';</script>";
        } else {
            echo "<script>alert('更新失败！请检查内容是否合法！');history.back();</script>";
        }
    }

    mysqli_close($db_connect);
