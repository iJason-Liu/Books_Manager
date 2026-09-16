<?php
    /*
     * 文章中 -插图- 上传（新闻/公告）
     * @author Jason Liu
     * wangEditor上传
     */
    header("Content-Type: application/json; charset=utf-8");
    include '../../classes/upload_helper.php';
    upload_require_auth('news_notice');

    if (!isset($_FILES['article_img'])) {
        upload_json_response(array('errno' => 1, 'message' => '未选择上传文件！'));
    }

    $result = upload_save_image($_FILES['article_img'], 'article/article_img');
    if ($result) {
        upload_json_response(array(
            'errno' => 0,
            'message' => 'success',
            'data' => array(
                'url' => $result['filepath'],
                'alt' => '插图',
                'href' => $result['href'],
            )
        ));
    }
    upload_json_response(array('errno' => 1, 'message' => '文件类型不支持或上传失败！'));
