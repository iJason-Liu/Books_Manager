<?php
    /*
     * 添加图书
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include './upload_bookCover.php';  //上传的封面文件

    // 阻止非登录用户和登录用户身份不符 进行操作
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../login/login.php'</script>";
    }else if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo "<script>alert('sorry，您暂无权限操作！');parent.location.reload();</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $isbn = $_POST['ISBN'];  //ISBN
	$name = $_POST['bookname']; //书名
    $author = $_POST['author']; //作者
    $publisher = $_POST['publisher']; //出版社
	$price = $_POST['bookprice']; //定价
    $number = $_POST['number']; //库存
	$type = $_POST['booktype']; //图书类别
    $place = $_POST['saveplace']; //保存书库
	$mark = $_POST['mark']; //简介
    //$file = $_POST['file'];  //获取上传的文件名
    $create_time = date('Y-m-d H:i:s', time()); //添加时间
    $status = 0;//图书状态 0在库，1借出

    $sql = "select * from book_list";
    $add_sql = "insert into book_list(ISBN,book_name,author,book_type,publisher,price,number,book_cover,mark,status,create_date,save_position)"."values('$isbn','$name','$author','$type','$publisher','$price','$number','$filepath','$mark','$status','$create_time','$place')";
    $is_book_name_equal = 0;  //判断图书是否存在
    $result = mysqli_query($db_connect,$sql);
    // 判断图书是否存在  条件：书名相同，出版社相同时拒绝添加
    while($row = mysqli_fetch_array($result)){
        if($name == $row['book_name'] && $publisher == $row['publisher']){
            $is_book_name_equal = 1;
            break;
        }
    }

    if($is_book_name_equal == 1){
        echo "<script>alert('您所添加的图书已经在库，请检查后重试！');history.back();</script>";
    }else if(isset($_POST['addition'])){
        $flag = mysqli_query($db_connect,$add_sql); //判断添加图书是否成功
        if($flag){
            echo 'success';
            echo "<script>alert('图书添加成功！');parent.location.replace('../../books_source/book_list.php');</script>";
        }else{
            echo mysqli_error($db_connect);  //执行错误的描述
            echo "<script>alert('图书添加失败！');parent.location.replace('../../books_source/book_list.php');</script>";
        }
    }

    mysqli_close($db_connect); //关闭数据库资源