<?php
    /*
     * 通过上传的Excel文件批量导入数据
     * @author Jason Liu
     */
    include '../config/conn.php';
    //引入PHPExcel类
    include '../plugins/phpexcel/PHPExcel.php';
    include '../plugins/phpexcel/PHPExcel/IOFactory.php';
    ini_set ("memory_limit","-1"); //取消php内存限制
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    header("Content-type:application/vnd.ms-excel;charset=UTF-8");
    //判断导入类型 0 图书 1 馆员 2 学生 3 教师
    $import_type = $_POST['import_type'];

    $sel_sql = "select * from book_list";
    $sel_result = mysqli_query($db_connect,$sel_sql);
    $before_rows = mysqli_num_rows($sel_result);
    // echo $before_rows.'before';  //执行前数据库内的总行数

    //用户上传的数据文件
    $file = $_FILES['file'];
    $filename = $file["name"];
    $excel_file = "../upload/excel/".time().'_'.$filename;
    //把文件存入文件夹
    $result = move_uploaded_file($file["tmp_name"],$excel_file);

    //文件导入数据库
    try {
        $inputFileType = PHPExcel_IOFactory::identify($excel_file);  //自动判断文件类型
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($excel_file); //加载文件
    } catch(Exception $e) {
        die('文件加载失败！"'.pathinfo($excel_file,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    $objWorksheet = $objPHPExcel->getActiveSheet();
    // $objWorksheet = $objPHPExcel->getSheet(0);
    $highestRow = $objWorksheet->getHighestDataRow();  //取得总行数
    $highestColumn = $objWorksheet->getHighestDataColumn(); //取得使用的总列数
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数
    // echo $highestRow;
    // echo $highestColumn;

    for($row = 2; $row <= $highestRow; $row++) {
        $field = array();
        //注意highestColumnIndex的列数索引从0开始
        for($col = 0; $col <= $highestColumnIndex; $col++) {
            $field[$col] = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
        $info = array(
            'word1'=>"$field[0]",
            'word2'=>"$field[1]",
            'word3'=>"$field[2]",
            'word4'=>"$field[3]",
            'word5'=>"$field[4]",
            'word6'=>"$field[5]",
            'word7'=>"$field[6]",
            'word8'=>"$field[7]",
            'word9'=>"$field[8]",
            'word10'=>"$field[9]",
        );
        // print_r($info);   //打印输出读取的内容（数组模式）

        //Excel对应数据库表格的字段（列为基准）
        // $field[0];  //这个字段是模版中的编号
        $isbn = $field[1];  //ISBN
        $name = $field[2]; //书名
        $author = $field[3]; //作者
        $type = $field[4]; //图书类别
        $publisher = $field[5]; //出版社
        $price = (float)$field[6]; //定价 Excel表对于数值型做一个强转float，来对应数据库字段类型
        $cover = $field[7]; //图书类别
        $mark = $field[8]; //简介
        $create_time = date('Y-m-d H:i:s', time()); //添加时间
        $place = $field[9]; //保存书库

        if($import_type == 0){
            /*
             * insert ignore into
             * 即插入数据时，如果数据存在，则忽略此次插入，
             * 前提条件是插入的数据字段设置了主键或唯一索引，
             * 当插入数据时，MySQL数据库会首先检索已有数据,
             * 如果存在，则忽略本次插入，如果不存在，则正常插入数据：
             *
             * insert if not exists
             * 即insert into … select … where not exist ... ，这种方式适合于插入的数据字段没有设置主键或唯一索引，
             * 当插入一条数据时，首先判断MySQL数据库中是否存在这条数据，
             * 如果不存在，则正常插入，如果存在，则忽略
             */
           //sql插入语句（图书数据）
           // $sql = "insert into book_list(ISBN,book_name,author,book_type,publisher,price,mark,book_cover,create_date,save_position)"
           //     ."values('$isbn','$name','$author','$type','$publisher','$price','$mark','$cover','$create_time','$place')";
            $sql = "insert into book_list(ISBN,book_name,author,book_type,publisher,price,mark,book_cover,create_date,save_position) select '$isbn','$name','$author','$type','$publisher','$price','$mark','$cover','$create_time','$place' from book_list where not exists(select book_name,publisher from book_list where book_name='$name' and publisher='$publisher');";
            $res = mysqli_query($db_connect, $sql);
        }else if($import_type == 1){
            /*
             * 以下三个表暂时不做重复判断
             */
            //sql插入语句（馆员数据）
            $sql = "insert into lib_worker(name,sex,mobile,user_type,createtime)"."values('$field[1]','$field[2]','$field[3]','$field[4]','$create_time')";
            $res = mysqli_query($db_connect, $sql);
            if($res){
                $id = mysqli_insert_id($db_connect);  //获取刚刚插入数据的自增id
                //把用户加入到权限表
                mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                    ." values ('$id','$field[1]','图书管理员','0','1','1','1','1','1','1','1','1','1','0')");
            }
        }else if($import_type == 2){
            //sql插入语句（学生数据）
            $sql = "insert into student(name,sex,department,class,mobile,createtime)"."values('$field[1]','$field[2]','$field[3]','$field[4]','$field[5]','$create_time')";
            $res = mysqli_query($db_connect, $sql);
            //每插入成功一条就对应插入一条权限数据
            if($res){
                $id = mysqli_insert_id($db_connect);  //获取刚刚插入数据的自增id
                //把用户加入到权限表
                mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                    ." values ('$id','$field[1]','学生','0','0','0','0','0','1','0','0','0','0','0')");
            }
        }else if($import_type == 3){
            //sql插入语句（教师数据）
            $sql = "insert into teacher(name,sex,department,class,mobile,createtime)"."values('$field[1]','$field[2]','$field[3]','$field[4]','$field[5]','$create_time')";
            $res = mysqli_query($db_connect, $sql);
            //每插入成功一条就对应插入一条权限数据
            if($res){
                $id = mysqli_insert_id($db_connect);  //获取刚刚插入数据的自增id
                //把用户加入到权限表
                mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                    ." values ('$id','$field[1]','教师','0','0','0','0','0','1','0','0','0','0','0')");
            }
        }
    }
    // 判断数据是否成功插入数据库
    // $result 文件是否成功上传   $res 是否成功导入数据库
    if($result){
        if($res){
            unlink($excel_file); //成功导入数据库后删除文件，避免数据冗余
            if($import_type == 0){
                //延迟5秒钟执行以下内容
                sleep(5);
                $sel_result = mysqli_query($db_connect,$sel_sql);
                $after_rows = mysqli_num_rows($sel_result);
                // echo $after_rows.'after';  //执行后数据库内总行数
                $n = $after_rows - $before_rows; //前后之差就是插入成功的行数
                $m = $highestRow - $n;  //失败行数
                if($n == 0){
                    echo json_encode(array('code' => 403, 'msg' => '导入失败，'.$m.'条数据已被忽略，请重试！'),JSON_UNESCAPED_UNICODE);
                }else{
                    echo json_encode(array('code' => 200, 'msg' => '成功导入'.$n.'条数据！'),JSON_UNESCAPED_UNICODE);
                }
            }else{
                echo json_encode(array('code' => 200, 'msg' => '数据导入成功！'),JSON_UNESCAPED_UNICODE);
            }
        }else{
            //不等于空的时候文件也上传成功了，所以也要删除
            if($filename != ''){
                unlink($excel_file);
            }
            // echo mysqli_error($db_connect);  //执行错误的描述
            echo json_encode(array('code' => 403, 'msg' => '导入失败！'),JSON_UNESCAPED_UNICODE);
        }
    }else{
        echo json_encode(array('code' => 0, 'msg' => '文件上传失败！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);

