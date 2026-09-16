<?php
    /*
     * 添加单本图书
     */
    session_save_path('../../session/');
    session_start();
    require_once __DIR__ . '/../../config/conn.php';
    $db_connect = get_db_connect();
    include __DIR__ . '/../../classes/check_rights.php';
    include __DIR__ . '/../../classes/upload_helper.php';

    header("Content-Type:text/html;charset=utf-8");

    if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
        exit;
    }
    if (!isset($item['book_manager']) || $item['book_manager'] == 0) {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
        exit;
    }

    $filepath = '';
    if (isset($_FILES['book_cover']) && $_FILES['book_cover']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload_result = upload_save_image($_FILES['book_cover'], 'bookCover');
        if ($upload_result) {
            $filepath = $upload_result['href'];
        } else {
            echo "<script>alert('封面上传失败，请检查文件格式！');history.back();</script>";
            exit;
        }
    } else if (!empty($_POST['book_cover_url'])) {
        $filepath = $_POST['book_cover_url'];
    }

    $isbn = $_POST['ISBN'] ?? '';
    $name = $_POST['bookname'] ?? '';
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $price = (float)($_POST['price'] ?? $_POST['bookprice'] ?? 0);
    $number = $_POST['number'] ?? 0;
    $type = $_POST['booktype'] ?? '';
    $place = $_POST['saveplace'] ?? '';
    $mark = $_POST['mark'] ?? '';
    $create_time = date('Y-m-d H:i:s', time());
    $status = 0;

    $sql = "select * from book_list";
    $add_sql = "insert into book_list(ISBN,book_name,author,book_type,publisher,price,number,book_cover,mark,status,create_date,save_position)"."values('$isbn','$name','$author','$type','$publisher','$price','$number','$filepath','$mark','$status','$create_time','$place')";
    $is_book_name_equal = 0;
    $result = mysqli_query($db_connect,$sql);
    while($row = mysqli_fetch_array($result)){
        if($name == $row['book_name'] && $publisher == $row['publisher']){
            $is_book_name_equal = 1;
            break;
        }
    }

    if ($is_book_name_equal == 1) {
        echo "<script>alert('您所添加的图书已经存在，请检查后重新提交！');history.back();</script>";
    } else if (isset($_POST['addition'])) {
        $flag = mysqli_query($db_connect, $add_sql);
        if ($flag) {
            echo "<script>alert('图书添加成功！');parent.location.href = '../../administrator/books_center/book_list';</script>";
        } else {
            echo "<script>alert('图书添加失败！');parent.location.href = '../../administrator/books_center/book_list';</script>";
        }
    }

    mysqli_close($db_connect);
