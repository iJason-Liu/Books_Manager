<?php
    /*
     * 图书封面上传
     * @author Jason Liu
     */
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $cover = $_FILES['book_cover'];
    $filename = $cover["name"];
    //上传的文件路径，可用于存入数据库的book_cover字段
    $filepath = "../../upload/bookCover/".time().'_'.$filename;
    $res = move_uploaded_file($cover["tmp_name"],$filepath);
    $src = substr($filepath,6);  //输出 upload后的所有内容
    $href = 'https://lib.crayon.vip/'.substr($filepath,6);  //把图片地址存为远程路径

    if($res){
        //前端需要即时反馈的返回值时 输出下列语句
        json_encode(array(
            'code' => 0,
            'msg' => 'success',
            'data' => array(
                'url' => $filepath,
                'alt' => '封面',  //图片描述文字
                'href' => 'https://lib.crayon.vip/'.$src, //图片链接
            )
        ),JSON_UNESCAPED_UNICODE);
    }else{
        json_encode(array('code' => 403, 'msg' => 'failure'),JSON_UNESCAPED_UNICODE);
    }
