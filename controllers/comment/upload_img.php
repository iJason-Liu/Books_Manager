<?php
    /*
     * 文章中 -插图- 上传（新闻/公告）
     * @author Jason Liu
     * wangEditor上传
     */
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");

    $file = $_FILES['article_img'];
    // print_r($file);
    $filename = $file["name"];
    //上传的文件路径，可用于存入数据库的article_img字段
    $filepath = "../../upload/article/article_img/".time().'_'.$filename;
    $res = move_uploaded_file($file["tmp_name"],$filepath);
    $href = substr($filepath,6);  //输出 upload/article/article_img/".time().'_'

    if($res){
        //前端需要即时反馈的返回值时 输出下列语句
        echo json_encode(array(
            'errno' => 0,  //返回值
            'message' => 'success',
            'data' => array(
                'url' => $filepath,   //图片路径
                'alt' => '插图',  //图片描述文字
                'href' => 'https://lib.crayon.vip/'.$href, //图片链接
            )
        ),JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('code' => 403, 'message' => 'failure'),JSON_UNESCAPED_UNICODE);
    }
