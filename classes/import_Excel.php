<?php
    /*
     * 通过上传的Excel文件批量导入数据
     * @author Jason Liu
     */
    require_once __DIR__ . '/../config/conn.php';
    /** @var mysqli $db_connect */
    include __DIR__ . '/upload_helper.php';
    require_once __DIR__ . '/session_helper.php';
    session_save_path(dirname(__DIR__) . '/session/');
    session_safe_start();

    header("Content-Type: application/json; charset=utf-8");

    if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] != 2) {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
        exit;
    }
    include 'check_rights.php';

    $import_type = isset($_POST['import_type']) ? (int)$_POST['import_type'] : -1;
    if ($import_type === 0 && (!isset($item['book_manager']) || $item['book_manager'] == 0)) {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($import_type !== 0 && (!isset($item['lib_worker']) || $item['lib_worker'] == 0)) {
        echo json_encode(array('code' => 403, 'msg' => '您暂无权限操作！'),JSON_UNESCAPED_UNICODE);
        exit;
    }

    include '../plugins/phpexcel/PHPExcel.php';
    include '../plugins/phpexcel/PHPExcel/IOFactory.php';
    ini_set("memory_limit","-1");

    if ($import_type < 0 || $import_type > 3) {
        echo json_encode(array('code' => 403, 'msg' => '导入类型无效！'),JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!isset($_FILES['file'])) {
        echo json_encode(array('code' => 403, 'msg' => '未选择上传文件！'),JSON_UNESCAPED_UNICODE);
        exit;
    }

    $excel_upload = upload_save_excel($_FILES['file']);
    if (!$excel_upload) {
        echo json_encode(array('code' => 403, 'msg' => '文件类型不支持或上传失败！'),JSON_UNESCAPED_UNICODE);
        exit;
    }
    $excel_file = $excel_upload['absolute_path'];

    $sel_sql = "select * from book_list";
    $sel_result = mysqli_query($db_connect,$sel_sql);
    $before_rows = mysqli_num_rows($sel_result);

    $res = false;
    try {
        $inputFileType = PHPExcel_IOFactory::identify($excel_file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($excel_file);
    } catch(Exception $e) {
        if (is_file($excel_file)) {
            unlink($excel_file);
        }
        echo json_encode(array('code' => 403, 'msg' => '文件加载失败，请检查模板格式！'),JSON_UNESCAPED_UNICODE);
        exit;
    }

    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestDataRow();
    $highestColumn = $objWorksheet->getHighestDataColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

    for($row = 2; $row <= $highestRow; $row++) {
        $field = array();
        for($col = 0; $col <= $highestColumnIndex; $col++) {
            $field[$col] = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }

        $isbn = $field[1] ?? '';
        $name = $field[2] ?? '';
        $author = $field[3] ?? '';
        $type = $field[4] ?? '';
        $publisher = $field[5] ?? '';
        $price = (float)($field[6] ?? 0);
        $cover = $field[7] ?? '';
        $mark = $field[8] ?? '';
        $create_time = date('Y-m-d H:i:s', time());
        $place = $field[9] ?? '';

        if($import_type == 0){
           $sql = "insert into book_list(ISBN,book_name,author,book_type,publisher,price,mark,book_cover,create_date,save_position)"
               ."values('$isbn','$name','$author','$type','$publisher','$price','$mark','$cover','$create_time','$place')";
            $res = mysqli_query($db_connect, $sql);
        }else if($import_type == 1){
            $sql = "insert into lib_worker(name,sex,mobile,user_type,createtime)"."values('$field[1]','$field[2]','$field[3]','$field[4]','$create_time')";
            $res = mysqli_query($db_connect, $sql);
            if($res){
                $id = mysqli_insert_id($db_connect);
                mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                    ." values ('$id','$field[1]','图书管理员','0','1','1','1','1','1','1','1','1','1','0')");
            }
        }else if($import_type == 2){
            $sql = "insert into student(name,sex,department,class,mobile,createtime)"."values('$field[1]','$field[2]','$field[3]','$field[4]','$field[5]','$create_time')";
            $res = mysqli_query($db_connect, $sql);
            if($res){
                $id = mysqli_insert_id($db_connect);
                mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                    ." values ('$id','$field[1]','学生','0','0','0','0','0','1','0','0','0','0','0')");
            }
        }else if($import_type == 3){
            $sql = "insert into teacher(name,sex,department,class,mobile,createtime)"."values('$field[1]','$field[2]','$field[3]','$field[4]','$field[5]','$create_time')";
            $res = mysqli_query($db_connect, $sql);
            if($res){
                $id = mysqli_insert_id($db_connect);
                mysqli_query($db_connect, "insert into rights(id,user_name,user_type,lib_worker,reader_list,reader_kind,book_manager,book_kind,borrowBook,record_search,comment_center,news_notice,feedBack,rights_center)"
                    ." values ('$id','$field[1]','教师','0','0','0','0','0','1','0','0','0','0','0')");
            }
        }
    }

    if($res){
        unlink($excel_file);
        if($import_type == 0){
            sleep(5);
            $sel_result = mysqli_query($db_connect,$sel_sql);
            $after_rows = mysqli_num_rows($sel_result);
            $n = $after_rows - $before_rows;
            $m = $highestRow - $n;
            if($n == 0){
                echo json_encode(array('code' => 403, 'msg' => '导入失败，'.$m.'条数据已被忽略，请重试！'),JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(array('code' => 200, 'msg' => '成功导入'.$n.'条数据！'),JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(array('code' => 200, 'msg' => '数据导入成功！'),JSON_UNESCAPED_UNICODE);
        }
    }else{
        if (is_file($excel_file)) {
            unlink($excel_file);
        }
        echo json_encode(array('code' => 403, 'msg' => '导入失败，请稍后再试！'),JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db_connect);
