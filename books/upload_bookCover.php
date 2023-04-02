<?php
    /*
     * 图书封面上传提交路径
     * @author Jason Liu
     */
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $cover = $_FILES['file'];
    $filename = $cover["name"];
    $path = "../upload/bookCover/".time().'_';
    //上传的文件路径，可用于存入数据库的book_cover字段
    $filepath = $path.$filename;
    $res = move_uploaded_file($cover["tmp_name"],$filepath);
    if($res){
        //前端需要即时反馈的返回值时 输出下列语句
        json_encode(array('code' => 200, 'msg' => 'success', 'data' => $filepath),JSON_UNESCAPED_UNICODE);
    }else{
        json_encode(array('code' => 403, 'msg' => 'failure', 'data' => $filepath),JSON_UNESCAPED_UNICODE);
    }
