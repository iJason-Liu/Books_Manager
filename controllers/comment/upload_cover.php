<?php
    /*
     * 文章封面上传（新闻/公告）
     * @author Jason Liu
     */
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $file = $_FILES['article_cover'];
    // print_r($file); die();
    $filename = $file["name"];
    //上传的文件路径，可用于存入数据库的article_cover字段
    $filepath = "../../upload/article/article_cover/".time().'_'.$filename;
    $res = move_uploaded_file($file["tmp_name"],$filepath);
    $href = substr($filepath,6);  //输出 upload/article/article_cover/".time().'_'

    if($res){
        //前端需要即时反馈的返回值时 输出下列语句
        echo json_encode(array(
            'code' => 0,
            'msg' => 'success',
            'data' => array(
                'url' => $filepath,   //图片路径
                'alt' => '封面',  //图片描述文字
                'href' => 'https://lib.crayon.vip/'.$href, //图片链接
            )
        ),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 403, 'msg' => 'failure'),JSON_UNESCAPED_UNICODE);
    }
