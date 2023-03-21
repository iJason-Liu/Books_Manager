<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';

    if ($_SESSION['is_flag'] != 2) {
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }else if ($_SESSION['usertype'] === '学生' || $_SESSION['usertype'] === '教师') {
        echo "<script>alert('sorry，您暂无权限操作！');parent.location.reload();</script>";
    }
//    添加时间和借阅状态默认
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $id = $_GET['id'];
    $isbn = $_POST['ISBN'];  //ISBN
	$name = $_POST['bookname']; //书名
    $author = $_POST['author']; //作者
    $publisher = $_POST['publisher']; //出版社
	$price = $_POST['bookprice']; //定价
	$type = $_POST['booktype']; //图书类别
    $place = $_POST['saveplace']; //保存书库
	$mark = $_POST['mark']; //简介
//    $file = $_POST['file'];  //获取上传的文件名
    $update_time = date('Y-m-d H:i:s', time()); //更新时间
    $status = '0'; //图书状态 0在库，1借出

    //上传的封面文件
    $cover = $_FILES['file'];
    $filename = $cover["name"];   //封面文件名
    $path = "../upload/bookCover/".time().'_';
    //上传的文件路径，可用于存入数据库的book_cover字段
    $filepath = $path.$filename;
    //同时删除对应的图书封面和图书源文件
    $sql_file = "select book_cover,book_source from book_list where book_id='$id'";
    $res_file = mysqli_query($db_connect,$sql_file);
    while($row = mysqli_fetch_array($res_file)){
        $coverPath = $row['book_cover']; //封面路径
        $sourcePath = $row['book_source']; //源文件路径
    }

    //执行sql更新语句
    $sql1 = "update book_list set ISBN='$isbn',book_name='$name',author='$author',publisher='$publisher',price='$price',book_type='$type',save_position='$place',mark='$mark',update_date='$update_time',book_cover='$filepath' where book_id='$id'";
    //当封面文件没有重新上传时不做更新$filePath
    $sql2 = "update book_list set ISBN='$isbn',book_name='$name',author='$author',publisher='$publisher',price='$price',book_type='$type',save_position='$place',mark='$mark',update_date='$update_time' where book_id='$id'";

    if(isset($_POST['update'])){
        if($filename != ''){
            $result = mysqli_query($db_connect,$sql1);
            //$row = mysqli_affected_rows($result); //影响行数
            //重定向页面
            if($result){
                //上传封面文件
                $res = move_uploaded_file($cover["tmp_name"],$filepath);
                if($res){
                    unlink($coverPath); //删除源封面
                    echo 'success';
                    //前端需要即时反馈的返回值时 输出下列语句
//                    json_encode(array('code' => 0, 'msg' => 'success', 'data' => $filepath),JSON_UNESCAPED_UNICODE);
                }
                echo "<script>alert('更新图书信息成功！');parent.location.replace('../books/books_list.php');</script>";
            }else{
                echo "<script>alert('更新失败！请检查内容是否合法！');history.back();</script>";
            }
        }else{
            $result2 = mysqli_query($db_connect,$sql2);
            //重定向页面
            if($result2){
                echo "<script>alert('更新图书信息成功！');parent.location.replace('../books/books_list.php');</script>";
            }else{
                echo "<script>alert('更新失败！请检查内容是否合法！');history.back();</script>";
            }
        }
    }

    mysqli_close($db_connect); //关闭数据库资源

