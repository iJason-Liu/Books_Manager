<?php
    //下载文件，模板
    $import_type = $_GET['import_type']; //前端传来的模板类型
    //文件路径
    if($import_type == 0){
        $fileurl = "../template/图书信息表（模板）.xlsx";
        $filename = "图书信息表（模板）.xlsx";
    }else if($import_type == 1){
        $fileurl = "../template/馆员信息表（模板）.xlsx";
        $filename = "馆员信息表（模板）.xlsx";
    }else if($import_type == 2){
        $fileurl = "../template/学生信息表（模板）.xlsx";
        $filename = "学生信息表（模板）.xlsx";
    }else if($import_type == 3){
        $fileurl = "../template/教师信息表（模板）.xlsx";
        $filename = "教师信息表（模板）.xlsx";
    }

    //打开服务器文件（返回文件流）
    $file = fopen($fileurl,'r');

    header('Content-Type: application/octet-stream'); //设置下载内容类型
    header('Content-Length: '.filesize($fileurl)); //设置下载内容长度
    header('Content-Disposition: attachment; filename='.$filename); //设置从服务器下载的本地文件名

    //输出 读区到的文件内容 （读文件流）
    echo fread($file,filesize($fileurl));

    //关闭服务器文件
    fclose($file);
