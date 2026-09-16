<?php
    /*
     * 文章封面上传（新闻/公告）
     * @author Jason Liu
     */
    header("Content-Type: application/json; charset=utf-8");
    include '../../classes/upload_helper.php';
    upload_require_auth('news_notice');

    if (!isset($_FILES['article_cover'])) {
        upload_json_response(array('code' => 403, 'msg' => '未选择上传文件！'));
    }

    $result = upload_save_image($_FILES['article_cover'], 'article/article_cover');
    if ($result) {
        upload_json_response(array(
            'code' => 0,
            'msg' => 'success',
            'data' => array(
                'url' => $result['filepath'],
                'alt' => '封面',
                'href' => $result['href'],
            )
        ));
    }
    upload_json_response(array('code' => 403, 'msg' => '文件类型不支持或上传失败！'));
